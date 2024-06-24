<?php namespace App\Controllers;

class Bankcard_control extends BaseController
{
    /*
    Protected
    */

    protected function getCurrency($code)
    {
        $payload = [
            'userid' => $_SESSION['token'],
            'code' => $code
        ];
        $res = $this->currency_model->selectCurrency($payload);
        return $res;
    }

    protected function bankList()
    {
        $payload = [
            'userid' => $_SESSION['token'],
            'paymentmethod' => 1,
            'status' => 1
        ];
        $res = $this->bank_model->bankList($payload);
        return $res;
    }

    /*
    Public
    */

    public function defaultBankCard()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'bankid' => base64_decode($this->request->getPost('params')['bank']),
            'accountholder' => $this->request->getPost('params')['holder'],
            'cardno' => $this->request->getPost('params')['cardno'],
            'accountno' => $this->request->getPost('params')['accno'],
            'display' => 1,
            'isdefault' => 1
        ];

        $res = $this->bankcard_model->updateBankCard($payload);
        echo json_encode($res);
    }

    public function addBankCard()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'bankid' => base64_decode($this->request->getPost('params')['bank']),
            'accountholder' => strtoupper($this->request->getPost('params')['holder']),
            'cardno' => preg_replace("/\s+/", "", strtolower($this->request->getPost('params')['accno'])),
            'accountno' => preg_replace("/\s+/", "", strtolower($this->request->getPost('params')['accno'])),
            'branch' => '',
            'display' => 1,
            'currencycode' => $_ENV['currencyCode'],
            'mindeposit' => 0,
            'maxdeposit' => 0,
            'minwithdrawal' => 0,
            'maxwithdrawal' => 0,
            'maxdailywithdrawal' => 0,
            'maxdailydeposit' => 0,
            'charges' => 0
        ];

        $res = $this->bankcard_model->insertBankCard($payload);
        // echo json_encode($res);
        if( $res['code']==1 ):
            $payloadDefault = [
                'userid' => $_SESSION['token'],
                'bankid' => base64_decode($this->request->getPost('params')['bank']),
                'accountholder' => strtoupper($this->request->getPost('params')['holder']),
                'cardno' => preg_replace("/\s+/", "", strtolower($this->request->getPost('params')['accno'])),
                'accountno' => preg_replace("/\s+/", "", strtolower($this->request->getPost('params')['accno'])),
                'display' => 1,
                'isdefault' => 1
            ];
            $resDefault = $this->bankcard_model->updateBankCard($payloadDefault);
            echo json_encode($resDefault);
        else:
            echo json_encode($res);
        endif;
    }

    public function userBankCardRawList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $currency = $this->bankList();

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->bankcard_model->bankCardList($payload);
        // echo json_encode($res);

        $data = [];
        if( $res['code']==1 && $res['data']!=[] ):
            foreach($res['data'] as $bc):
                $code = '';
                foreach( $currency['data'] as $cd ):
                    if( $cd['bankId']==$bc['bankId'] ):
                        $code = $cd['currencyCode'][0];
                    endif;
                endforeach;

                $currencyRate = $this->getCurrency($code);
                if( $currencyRate['code']==1 && $currencyRate['data']!=[] ):
                    $depositRate = $currencyRate['data']['depositRate'];
                    $withdrawRate = $currencyRate['data']['withdrawalRate'];
                else:
                    $depositRate = 1;
                    $withdrawRate = 1;
                endif;

                $row = [];
                $row['bank'] = base64_encode($bc['bankId']);
                $row['currency'] = $code;
                $row['name'] = $bc['name'][$lng];
                $row['cardno'] = $bc['cardNo'];
                $row['accno'] = $bc['accountNo'];
                $row['holder'] = $bc['accountHolder'];
                $row['remark'] = $bc['remark'];
                $row['isDefault'] = $bc['isDefault'];
                $row['depositRate'] = $depositRate;
                $row['withdrawRate'] = $withdrawRate;
                $data[] = $row;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        else:
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        endif;
    }

    public function userBankCard()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $raw = $this->bankcard_model->bankCardList(['userid'=>$_SESSION['token']]);
        // echo json_encode($raw);

        if( $raw['code'] == 1 && $raw['data'] != [] ):
            $data = [];
            foreach( $raw['data'] as $bc ):
                switch($bc['status']):
                    case 1: $status = lang('Label.active'); break;
                    case 2: $status = lang('Label.inactive'); break;
                    default: $status = '---';
                endswitch;

                switch( $bc['isDefault'] ):
                    case 1:
                        $primary = '<small class="badge bg-success fw-normal me-1">'.lang('Label.active').'</small>';
                    break;
                    
                    default:
                        $primary = '<small class="badge bg-danger fw-normal me-1">'.lang('Label.inactive').'</small>';
                endswitch;

                $action = '<div class="btn-group">';

                if( $bc['isDefault']==1 ):
                    $action .= '<button type="button" class="btn btn-success btn-sm");">'.lang('Label.yes').'</button>';
                else:
                    $action .= '<button type="button" class="btn btn-dark btn-sm" onclick="setDefault(\''.base64_encode($bc['bankId']).'\',\''.$bc['accountHolder'].'\',\''.$bc['accountNo'].'\',\''.$bc['cardNo'].'\');">'.lang('Label.no').'</button>';
                endif;

                $action .= '</div>';

                $row = [];
                $row[] = $primary.'<small class="badge bg-dark me-1 fw-normal">'.$bc['name'][$lng].'</small>'.$bc['accountNo'];
                $row[] = $bc['accountHolder'];
                $row[] = $status;
                $row[] = $action;
                $data[] = $row;
            endforeach;
            echo json_encode(['data'=>$data]);
        else:
            echo json_encode(['no data']);
        endif;
    }

    public function companyBankCard()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $currency = $this->bankList();

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $res = $this->bankcard_model->companyBankCardList($payload);
        // echo json_encode($res);

        $data = [];
        if( $res['code']==1 && $res['data']!=[] ):
            foreach($res['data'] as $bc):
                $code = '';
                // Get Currency Code
                foreach( $currency['data'] as $cd ):
                	if( $cd['bankId']==$bc['bankId'] ):
                		$code = $cd['currencyCode'][0];
                	endif;
                endforeach;
                // End Get Currency Code

                $row = [];
                $row['bank'] = base64_encode($bc['bankId']);
                $row['name'] = $bc['name'][$lng];
                $row['currency'] = $code;
                $row['cardno'] = $bc['cardNo'];
                $row['accno'] = $bc['accountNo'];
                $row['holder'] = $bc['accountHolder'];
                $row['remark'] = $bc['remark'];
                $row['minDeposit'] = $bc['minDeposit'];
                $row['maxDeposit'] = $bc['maxDeposit'];
                $row['minWithdrawal'] = $bc['minWithdrawal'];
                $row['maxWithdrawal'] = $bc['maxWithdrawal'];
                $row['maxDailyDeposit'] = $bc['maxDailyDeposit'];
                $row['maxDailyWithdrawal'] = $bc['maxDailyWithdrawal'];
                $row['qrCodeUrl'] = $bc['qrCodeUrl'];
                $data[] = $row;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        else:
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        endif;
    }
}