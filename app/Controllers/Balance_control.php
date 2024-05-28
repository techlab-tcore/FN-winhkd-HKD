<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Balance_control extends BaseController
{
    /*
    Protected
    */

    protected function userProfile()
    {
        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->user_model->selectUser($payload);
        return $res;
    }

    protected function userDefaultBankCard()
    {
        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->bankcard_model->bankCardList($payload);
        $defaultBcHolder = '';
        if( $res['code']==1 && $res['data']!=[] ):
            foreach( $res['data'] as $bc ):
                if( $bc['isDefault']==1 ):
                    $defaultBcHolder .= $bc['accountHolder'];
                endif;
            endforeach;
            return $defaultBcHolder;
        endif;
    }

    /*
    Claim Promotion
    */

    public function claimPromotion()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $now = new Time('now');

        $payload = [
            'userid' => $_SESSION['token'],
            'type' => 1,
            'method' => 1,
            'wallettype' => 1,
            'amount' => 0,
            'depositdate' => date('c', strtotime($now)),
            'ip' => $_SESSION['ip'],
            'adminbankid' => null,
            'admincardno' => null,
            'adminaccountno' => null,
            'slipname' => null,
            'promotionid' => base64_decode($this->request->getPost('params')['promotion'])
        ];

        $res = $this->balance_model->insertTransaction($payload);
        echo json_encode($res);
    }
    
    /*
    Transaction
    */

    public function withdrawal()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $userFullName = $this->userProfile();
        $userBankCard =  $this->userDefaultBankCard();

        if( strtoupper($userFullName['data']['name'])!==strtoupper($userBankCard) ):
            echo json_encode([
                'code' => -1,
                'message' => lang('Validation.accnamenomatch'),
            ]);
        else:
            $payload = [
                'userid' => $_SESSION['token'],
                'type' => 2,
                'wallettype' => 1,
                'currencycode' => $this->request->getPost('params')['currency'],
                'amount' => (float)$this->request->getPost('params')['amount'],
                'ip' => $_SESSION['ip'],
            ];
            $res = $this->balance_model->insertTransaction($payload);
            echo json_encode($res);
        endif;
    }

    public function expressDeposit()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $now = new Time('now');

        if( !isset($this->request->getPost('params')['promotion']) || empty($this->request->getPost('params')['promotion']) ):
            $promo = '';
        else:
            $promo = base64_decode($this->request->getPost('params')['promotion']);
        endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'type' => 1,
            'method' => 2,
            'wallettype' => 1,
            'currencycode' => $this->request->getPost('params')['currency'],
            'amount' => (float)$this->request->getPost('params')['amount'],
            'depositdate' => date('c', strtotime($now)),
            'ip' => $_SESSION['ip'],
            'bankid' => base64_decode($this->request->getPost('params')['bankid']),
            'merchantcode' => $this->request->getPost('params')['merchant'],
            'channelcode' => $this->request->getPost('params')['channel'],
            'promotionid' => $promo
        ];

        $res = $this->balance_model->insertTransaction($payload);
        echo json_encode($res);
    }

    public function bankTransfer()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $now = new Time('now');

        if( !isset($this->request->getPost('params')['promotion']) || empty($this->request->getPost('params')['promotion']) ):
            $promo = '';
        else:
            $promo = base64_decode($this->request->getPost('params')['promotion']);
        endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'type' => 1,
            'method' => 1,
            'wallettype' => 1,
            'currencycode' => $this->request->getPost('params')['currency'],
            'amount' => (float)$this->request->getPost('params')['amount'],
            'depositdate' => date('c', strtotime($now)),
            'ip' => $_SESSION['ip'],
            'adminbankid' => base64_decode($this->request->getPost('params')['bank']),
            'admincardno' => $this->request->getPost('params')['card'],
            'adminaccountno' => $this->request->getPost('params')['accno'],
            'slipname' => $this->request->getPost('params')['slip'],
            'promotionid' => $promo
        ];

        $res = $this->balance_model->insertTransaction($payload);
        $merge = array_merge([
            'agentid' =>$_ENV['host'],
            'sessionid' => $_SESSION['session'],
            'userid' => $_SESSION['token'],
            'slipname' => $this->request->getPost('params')['slip']
        ], $res);
        echo json_encode($merge);
    }

    public function countDailyTransaction()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $from = date('c', strtotime(date('Y-m-d 00:00:00')));
        $to = date('c', strtotime(date('Y-m-d 23:59:59')));

        $type = $this->request->getPost('params')['type'];
        $payload = [
            'userid' => $_SESSION['token'], 
            'type' => (int)$type, 
            'status' => 1, 
            'fromdate' => $from,
            'todate'=>$to,
            'self' => true,
            'desc' => true
        ];
        $res = $this->balance_model->selectAllTransactionHistory($payload);
        if( $res['code']==1 && $res['data']!=[] ):
            $count = count($res['data']);
        else:
            $count = 0;
        endif;

        echo json_encode([
            'code' => $res['code'],
            'message' => $res['message'],
            'count' => (int)$count
        ]);
    }

    public function transactionHistoryList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $raw = json_decode(file_get_contents('php://input'),1);

        if( !empty($raw['start']) && !empty($raw['end']) ):
            $from = date('c', strtotime(date('Y-m-d 00:00:00', strtotime($raw['start']))));
            $to = date('c', strtotime(date('Y-m-d 23:59:59', strtotime($raw['end']))));
        else:
            $from = date('c', strtotime(date('Y-m-d 00:00:00')));
            $to = date('c', strtotime(date('Y-m-d 23:59:59')));
        endif;

        $payload = $this->balance_model->selectAllTransactionHistory([
            'userid' => $_SESSION['token'], 
            'type' => (int)$raw['type'], 
            'status' => 0, 
            'fromdate' => $from,
            'todate'=>$to,
            'self' => true,
            'pageindex' => $raw['pageindex'],
            // 'rowperpage' => 8
            'rowperpage' => $raw['rowperpage'],
            'desc' => true
        ]);
        // echo json_encode($payload);

        if( $payload['code'] == 1 && $payload['data'] != [] ):
            $data = [];
            foreach( $payload['data'] as $ph ):
                switch($ph['status']):
                    case 1: $status = '<span class="text-success">'.lang('Label.success').'</span>'; break;
                    case 2: $status = '<span class="text-danger">'.lang('Label.reject').'</span>'; break;
                    case 3: $status = '<span class="text-warning">'.lang('Label.pending').'</span>'; break;
                    case 4: $status = '<span class="text-info">'.lang('Label.check').'</span>'; break;
                    default: $status = '---';
                endswitch;

                switch($ph['type']):
                    case 1: $type = lang('Label.deposit'); break;
                    case 2: $type = lang('Label.withdrawal'); break;
                    case 3: $type = lang('Label.bonus'); break;
                    case 4: $type = lang('Label.rebate'); break;
                    case 5: $type = lang('Label.affiliate'); break;
                    case 6: $type = lang('Label.credittransfer'); break;
                    case 7: $type = lang('Label.wreturn'); break;
                    case 8: $type = lang('Label.jackpot'); break;
                    case 9: $type = lang('Label.fortunetoken'); break;
                    case 10: $type = lang('Label.pgtransfer'); break;
                    case 11: $type = lang('Label.refcomm'); break;
                    case 12: $type = lang('Label.depcomm'); break;
                    case 13: $type = lang('Label.lossrebate'); break;
                    case 14: $type = lang('Label.affsharereward'); break;
                    case 15: $type = lang('Label.dailyfreereward'); break;
                    case 16: $type = lang('Label.affloserebate'); break;
                    case 17: $type = lang('Label.fortunereward'); break;
                    default: $type = '';
                endswitch;

                switch($ph['method']):
                    case 1: $method = lang('Nav.banktransfer'); break;
                    case 2: $method = lang('Nav.pgateway'); break;
                    case 3: $method = lang('Nav.topupcode'); break;
                    default: $method = '---';
                endswitch;

                $date = Time::parse(date('Y-m-d H:i:s', strtotime($ph['createDate'])));
                $created = $date->toDateTimeString();

                $row = [];
                $row[] = $created;
                $row[] = $status;
                $row[] = '<span class="badge bg-primary fw-normal me-1">'.$type.'</span>'.$method;
                $row[] = $ph['amount'];
                $data[] = $row;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>1, 'pageIndex'=>$payload['pageIndex'], 'rowPerPage'=>$payload['rowPerPage'], 'totalPage'=>$payload['totalPage'], 'totalRecord'=>$payload['totalRecord']]);
        else:
            echo json_encode(['no data']);
        endif;
    }

    public function todayTransaction()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $from = date('c', strtotime(date('Y-m-d 00:00:00')));
        $to = date('c', strtotime(date('Y-m-d 23:59:59')));

        $payload = $this->balance_model->selectAllTransactionHistory([
            'userid' => $_SESSION['token'], 
            'type' => (int)$this->request->getPost('params')['type'], 
            'status' => 1, 
            'fromdate' => $from,
            'todate'=>$to,
            'self' => true,
            'pageindex' => 1,
            'rowperpage' => 1,
            'desc' => true
        ]);
        // echo json_encode($payload);
        if( $payload['code']==1 && $payload['data']!=[] ):
            foreach( $payload['data'] as $t ):
                $date = Time::parse(date('Y-m-d H:i:s', strtotime($t['createDate'])));
                $created = $date->toDateTimeString();

                $row = [];
                $row['paymentId'] = base64_encode($t['paymentId']);
                $row['type'] = $t['type'];
                $row['status'] = $t['status'];
                $row['amount'] = $t['amount'];
                $row['depositDate'] = $created;
            endforeach;
            echo json_encode([
                'code' => $payload['code'],
                'message' => $payload['message'],
                'data' => $row
            ]);
        else:
            echo json_encode([
                'code' => $payload['code'],
                'message' => $payload['message'],
                'data' => []
            ]);
        endif;
    }

    /*
    Player
    */

    public function userTransfer()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'tologinid' => $this->request->getPost('params')['playerid'],
            'selftransfer' => false,
            'amount' => (float)$this->request->getPost('params')['amount'],
            'ip' => $_SESSION['ip'],
            'fromwallet' => 1,
            'towallet' => 1
        ];

        $res = $this->balance_model->updateUserTransfer($payload);
        echo json_encode($res);
    }

    public function userTransferHistory()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $raw = json_decode(file_get_contents('php://input'),1);

        if( !empty($raw['start']) && !empty($raw['end']) ):
            $from = date('c', strtotime(date('Y-m-d 00:00:00', strtotime($raw['start']))));
            $to = date('c', strtotime(date('Y-m-d 23:59:59', strtotime($raw['end']))));
        else:
            $from = date('c', strtotime(date('Y-m-d 00:00:00')));
            $to = date('c', strtotime(date('Y-m-d 23:59:59')));
        endif;

        $payload = $this->balance_model->selectAllUserTransferHistory([
            'userid' => $_SESSION['token'], 
            'fromdate' => $from,
            'todate' => $to,
            'self' => filter_var($raw['self'], FILTER_VALIDATE_BOOLEAN), 
            'pageindex' => $raw['pageindex'],
            'rowperpage' => $raw['rowperpage'],
            'desc' => true
        ]);
        // echo json_encode($payload);

        if( $payload['code'] == 1 && $payload['data'] != [] ):
            $data = [];
            foreach( $payload['data'] as $t ):
                switch($t['approve']):
                    case true: $status = lang('Label.approve'); break;
                    case false: $status = lang('Label.reject'); break;
                    default: $status = '---';
                endswitch;

                if( !empty($t['paymentCode']) && empty($t['topUpCode']) ):
                    $type = lang('Nav.topupcode');
                elseif( empty($t['paymentCode']) && !empty($t['topUpCode']) ):
                    $type = lang('Nav.paymentcode');
                else:
                    $type = lang('Nav.utransfer');
                endif;

                switch($t['fromWallet']):
                    case 1: $fromWallet = lang('Label.cash'); break;
                    case 2: $fromWallet = 'Agent Wallet'; break;
                    case 3: $fromWallet = lang('Label.chip'); break;
                    case 4: $fromWallet = lang('Label.fortunetoken'); break;
                    default: $fromWallet = '---';
                endswitch;

                switch($t['toWallet']):
                    case 1: $toWallet = lang('Label.cash'); break;
                    case 2: $toWallet = 'Agent Wallet'; break;
                    case 3: $toWallet = lang('Label.chip'); break;
                    case 4: $toWallet = lang('Label.fortunetoken'); break;
                    default: $toWallet = '---';
                endswitch;

                $date = Time::parse(date('Y-m-d H:i:s', strtotime($t['createDate'])));
                $created = $date->toDateTimeString();

                $row = [];
                $row[] = $created;
                $row[] = $status;
                $row[] = $type;
                $row[] = '<small class="badge bg-dark fw-normal me-1">'.$fromWallet.'</small><small class="badge bg-dark fw-normal me-1">'.$t['ip'].'</small>'.$t['fromLoginId'];
                $row[] = '<small class="badge bg-dark fw-normal me-1">'.$toWallet.'</small>'.$t['toLoginId'];
                $row[] = $t['amount'];
                $data[] = $row;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>1, 'pageIndex'=>$payload['pageIndex'], 'rowPerPage'=>$payload['rowPerPage'], 'totalPage'=>$payload['totalPage'], 'totalRecord'=>$payload['totalRecord']]);
        else:
            echo json_encode(['no data']);
        endif;
    }
}