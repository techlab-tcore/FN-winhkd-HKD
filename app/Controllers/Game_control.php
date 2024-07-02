<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Game_control extends BaseController
{
	/*
	Protected
	*/

	protected function reorderGameProviderAgentList($type)
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->gameprovider_model->selectAllAgentGameProvider($payload);
        if( $res['code']==1 && $res['data']!=[] ):
            switch( $type['type'] ):
                case 33: $category = 3; break;
                default:
                    $category = $type['type'];
            endswitch;

            $data = [];
            foreach( $res['data'] as $g ):
                foreach( $g['type'] as $key=>$gtype ):
                    if( $gtype['type']==$category ):
                        if( $gtype['type']==3 ):
                            if( $g['code']!='RCB' && $type['type']==3 ):
                                $row = [];
                                $row['status'] = $g['status'];
                                $row['code'] = $g['code'];
                                $row['name'] = $g['name'][$lng];
                                $row['order'] = $g['order'];
                                $row['category'] = $gtype['type'];
                                $data[] = $row;
                            elseif( $g['code']=='RCB' && $type['type']==3 ):
                                $row = [];
                                $row['status'] = $g['status'];
                                $row['code'] = $g['code'];
                                $row['name'] = $g['name'][$lng];
                                $row['order'] = $g['order'];
                                // $row['category'] = $gtype['type'];
                                $row['category'] = $type['type'];
                                $data[] = $row;
                            endif;
                        else:
                            $row = [];
                            $row['status'] = $g['status'];
                            $row['code'] = $g['code'];
                            $row['name'] = $g['name'][$lng];
                            $row['order'] = $g['order'];
                            $row['category'] = $gtype['type'];
                            $data[] = $row;
                        endif;
                    endif;
                endforeach;
            endforeach;
            $games['data'] = $data;
            $result = array_merge(['code'=>$res['code'], 'message'=>$res['message']],$games);
        else:
            $result = ['code'=>$res['code'], 'message'=>$res['message']];
        endif;
        return $result;
    }

    protected function checkLatestSecoreLog()
    {
        $earlier = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $from = date('c', strtotime(date('Y-m-d 00:00:00', strtotime($earlier))));
        $to = date('c', strtotime(date('Y-m-d 23:59:59')));

        $payload = [
            'userid' => $_SESSION['token'],
            'fromdate' => $from,
            'todate' => $to,
            'pageindex' => 1,
            'rowperpage' => 1,
            'desc' => true
        ];
        $res = $this->game_model->selectAllGameCreditLog($payload);
        return $res;
    }

    protected function userProfile()
    {
        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->user_model->selectUser($payload);
        return $res;
    }

    /*
    Public
    */

    public function getGameBalance()
    {
        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $this->request->getPost('params')['provider']
        ];
        $res = $this->game_model->selectGameBalance($payload);
        echo json_encode($res);
    }

    public function closeLobby()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $this->request->getPost('params')['provider']
        ];
        $res = $this->game_model->selectGameBalance($payload);
        // echo json_encode($res);
        if( $res['code']==1 ):
            // if( $res['balance']>0 ):
                $payload2 = [
                    'userid' => $_SESSION['token'],
                    'gameprovidercode' => $this->request->getPost('params')['provider'],
                    'transfertype' => (int)$this->request->getPost('params')['type'],
                    'amount' => (float)$res['balance']
                ];
                $res2 = $this->game_model->updateGameCredit($payload2);
                echo json_encode($res2);
            // else:
            //     echo json_encode($res);
            // endif;
        else:
            echo json_encode($res);
        endif;
    }

    public function withdrawLatestGame()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $res = $this->checkLatestSecoreLog();
        if( $res['code']==1 && $res['data']!=[] ):
            $payloadGetBalance = [
                'userid' => $_SESSION['token'],
                'gameprovidercode' => $res['data'][0]['gameProviderCode']
            ];
            $resGetBalance = $this->game_model->selectGameBalance($payloadGetBalance);
            // Recall all the balance & update after-amount
            if( $resGetBalance['code']==1 || $resGetBalance['code']==71 ):
                $payloadTransfer = [
                    'userid' => $_SESSION['token'],
                    'gameprovidercode' => $resGetBalance['gameProviderCode'],
                    'transfertype' => 2,
                    'amount' => (float)$resGetBalance['balance']
                ];
                $resTransfer = $this->game_model->updateGameCredit($payloadTransfer);
                echo json_encode($resTransfer);
            endif;
        else:
            echo json_encode($res);
        endif;
    }

    public function openSlotGame()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $this->request->getPost('params')['provider'],
            'gamecode' => $this->request->getPost('params')['gcode'],
            'ismobile' => (int)$this->request->getPost('params')['isMobile']
        ];
        $res = $this->game_model->selectGameSlot($payload);
        if( $res['code']==1 ):
            // Check latest 7 days score log
            $payloadScoreLog = $this->checkLatestSecoreLog();
            if( $payloadScoreLog['code']==1 ):
                // Get leftover balance
                if( $payloadScoreLog['data']!=[] ):
                    $payloadGetBalance = [
                        'userid' => $_SESSION['token'],
                        'gameprovidercode' => $payloadScoreLog['data'][0]['gameProviderCode']
                    ];
                    $resGetBalance = $this->game_model->selectGameBalance($payloadGetBalance);
                    // Recall all the balance & update after-amount
                    if( $resGetBalance['code']==1 || $resGetBalance['code']==71 ):
                        if( $payloadScoreLog['data'][0]['gameProviderCode']!=$this->request->getPost('params')['provider'] ):
                            // If not same as previous game
                            if( $resGetBalance['code']!=71 ):
                                // DIY Lottery Exceptional
                                if( $resGetBalance['gameProviderCode']!='GD' || $resGetBalance['gameProviderCode']!='GDS' ):
                                    // Lottery credit below 1
                                    if( 
                                        ($resGetBalance['gameProviderCode']=='GD2' || $resGetBalance['gameProviderCode']=='GD8') && 
                                        $resGetBalance['balance']<1
                                    ):
                                        $resTransfer = [
                                            'code' => 1,
                                        ];
                                    else:
                                        $payloadTransfer = [
                                            'userid' => $_SESSION['token'],
                                            'gameprovidercode' => $resGetBalance['gameProviderCode'],
                                            'transfertype' => 2,
                                            'amount' => (float)$resGetBalance['balance']
                                        ];
                                        $resTransfer = $this->game_model->updateGameCredit($payloadTransfer);
                                    endif;
                                    // End Lottery credit below 1
                                else:
                                    $resTransfer = [
                                        'code' => 1,
                                    ];
                                endif;
                                // End DIY Lottery Exceptional
                            else:
                                $resTransfer = [
                                    'code' => 1,
                                ];
                            endif;

                            // Transfer-in to game
                            if( $resTransfer['code']==1 ):
                                // $credit = $this->request->getPost('params')['credit']>=1 ? $this->request->getPost('params')['credit'] : $resGetBalance['balance'];
                                $credit = $this->request->getPost('params')['credit'] + $resGetBalance['balance'];

                                $payloadTransferIn = [
                                    'userid' => $_SESSION['token'],
                                    'gameprovidercode' => $this->request->getPost('params')['provider'],
                                    //'transfertype' => (int)$this->request->getPost('params')['type'],
                                    'transfertype' => 1,
                                    'amount' => (float)$credit
                                ];
                                $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                                $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                                echo json_encode($result);
                            else:
                                echo json_encode($resTransfer);
                            endif;
                            // End If not same as previous game
                        else:
                            // If same as previous game
                            if( $this->request->getPost('params')['credit']>0 ):
                                $credit = $this->request->getPost('params')['credit']>0 ? $this->request->getPost('params')['credit'] : $resGetBalance['balance'];

                                $payloadTransferIn = [
                                    'userid' => $_SESSION['token'],
                                    'gameprovidercode' => $this->request->getPost('params')['provider'],
                                    //'transfertype' => (int)$this->request->getPost('params')['type'],
                                    'transfertype' => 1,
                                    'amount' => (float)$credit
                                ];
                                $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                                $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                                echo json_encode($result);
                            else:
                                echo json_encode([
                                    'code' => $resGetBalance['code'],
                                    'message' => $resGetBalance['message'],
                                    'url' => $res['url']
                                ]);
                            endif;
                            // End If same as previous game
                        endif;
                    else:
                        echo json_encode($resGetBalance);
                    endif;
                else:
                    $credit = $this->request->getPost('params')['credit']>0 ? $this->request->getPost('params')['credit'] : 0;
                    $payloadTransferIn = [
                        'userid' => $_SESSION['token'],
                        'gameprovidercode' => $this->request->getPost('params')['provider'],
                        //'transfertype' => (int)$this->request->getPost('params')['type'],
                        'transfertype' => 1,
                        'amount' => (float)$credit
                    ];
                    $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                    $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                    echo json_encode($result);
                endif;
            else:
                echo json_encode($payloadScoreLog);
            endif;
        else:
            echo json_encode($res);
        endif;
    }

    public function partialTransferOpenGame()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $inputType = $this->request->getPost('params')['type'];
        $inputGP = $this->request->getPost('params')['provider'];
        $inputCredit = $this->request->getPost('params')['amount'];

        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $inputGP,
            'ismobile' => (int)$this->request->getPost('params')['isMobile']
        ];
        $res = $this->game_model->selectGameLobby($payload);
        // echo json_encode($res);

        if( $res['code']==1 && !empty($res['url']) ):
            $payloadTransferIn = [
                'userid' => $_SESSION['token'],
                'gameprovidercode' => $inputGP,
                'transfertype' => (int)$inputType,
                'amount' => (float)$inputCredit
            ];
            $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
            if( $resTransferIn['code']==1 ):
                $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                echo json_encode($result);
            else:
                echo json_encode($resTransferIn);
            endif;
        else:
            echo json_encode($res);
        endif;
    }

    public function openLobby_old()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $this->request->getPost('params')['provider'],
            'ismobile' => filter_var($this->request->getPost('params')['isMobile'], FILTER_VALIDATE_BOOLEAN)
        ];

        $res = $this->game_model->selectGameLobby($payload);
        // echo json_encode($res);
        if( $res['code']==1 ):
            // Check latest 7 days score log
            $payloadScoreLog = $this->checkLatestSecoreLog();
            if( $payloadScoreLog['code']==1 ):
                // Get leftover balance
                if( $payloadScoreLog['data']!=[] ):
                    $payloadGetBalance = [
                        'userid' => $_SESSION['token'],
                        'gameprovidercode' => $payloadScoreLog['data'][0]['gameProviderCode']
                    ];
                    $resGetBalance = $this->game_model->selectGameBalance($payloadGetBalance);

                    // Recall all the balance & update after-amount
                    if( $resGetBalance['code']==1 || $resGetBalance['code']==71 ):
                        if( $payloadScoreLog['data'][0]['gameProviderCode']!=$this->request->getPost('params')['provider'] ):
                            // If not same as previous game
                            if( $resGetBalance['code']!=71 ):
                                // DIY Lottery
                                // DIY Lottery Exceptional
                                if( $resGetBalance['gameProviderCode']!='GD' || $resGetBalance['gameProviderCode']!='GDS' ):
                                    // Lottery credit below 1
                                    if( 
                                        ($resGetBalance['gameProviderCode']=='GD2' || $resGetBalance['gameProviderCode']=='GD8') && 
                                        $resGetBalance['balance']<1
                                    ):
                                        $resTransfer = [
                                            'code' => 1,
                                        ];
                                    else:
                                        $payloadTransfer = [
                                            'userid' => $_SESSION['token'],
                                            'gameprovidercode' => $resGetBalance['gameProviderCode'],
                                            'transfertype' => 2,
                                            'amount' => (float)$resGetBalance['balance']
                                        ];
                                        $resTransfer = $this->game_model->updateGameCredit($payloadTransfer);
                                    endif;
                                    // End Lottery credit below 1
                                else:
                                    $resTransfer = [
                                        'code' => 1,
                                    ];
                                endif;
                                // End DIY Lottery Exceptional
                                // END DIY Lottery
                            else:
                                $resTransfer = [
                                    'code' => 1,
                                ];
                            endif;

                            // Transfer-in to game
                            if( $resTransfer['code']==1 ):
                                // $credit = $this->request->getPost('params')['credit']>=1 ? $this->request->getPost('params')['credit'] : $resGetBalance['balance'];
                                // $credit = $this->request->getPost('params')['credit'] + $resGetBalance['balance'];
                                // $credit = $this->request->getPost('params')['credit']>=0 ? $this->request->getPost('params')['credit'] : $payloadScoreLog['data'][0]['amount'];
                                $credit = $this->request->getPost('params')['credit'] + $payloadScoreLog['data'][0]['amount'];

                                $payloadTransferIn = [
                                    'userid' => $_SESSION['token'],
                                    'gameprovidercode' => $this->request->getPost('params')['provider'],
                                    'transfertype' => (int)$this->request->getPost('params')['type'],
                                    'amount' => (float)$credit
                                ];
                                $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                                $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                                echo json_encode($result);
                            else:
                                echo json_encode($resTransfer);
                            endif;
                            // End If not same as previous game
                        else:
                            // If same as previous game
                            if( $this->request->getPost('params')['credit']>0 ):
                                $credit = $this->request->getPost('params')['credit']>0 ? $this->request->getPost('params')['credit'] : 0;

                                $payloadTransferIn = [
                                    'userid' => $_SESSION['token'],
                                    'gameprovidercode' => $this->request->getPost('params')['provider'],
                                    'transfertype' => (int)$this->request->getPost('params')['type'],
                                    'amount' => (float)$credit
                                ];
                                $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                                $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                                echo json_encode($result);
                            else:
                                echo json_encode([
                                    'code' => $resGetBalance['code'],
                                    'message' => $resGetBalance['message'],
                                    'url' => $res['url']
                                ]);
                            endif;
                            // End If same as previous game
                        endif;
                    else:
                        echo json_encode($resGetBalance);
                    endif;
                else:
                    // For Empty Score-log
                    $credit = $this->request->getPost('params')['credit']>0 ? $this->request->getPost('params')['credit'] : $payloadScoreLog['data'][0]['amount'];
                    $payloadTransferIn = [
                        'userid' => $_SESSION['token'],
                        'gameprovidercode' => $this->request->getPost('params')['provider'],
                        'transfertype' => (int)$this->request->getPost('params')['type'],
                        'amount' => (float)$credit
                    ];
                    $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                    $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                    echo json_encode($result);
                    // End For Empty Score-log
                endif;
            else:
                echo json_encode($payloadScoreLog);
            endif;
        else:
            echo json_encode($res);
        endif;
    }

    public function openLobby()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $inputType = $this->request->getPost('params')['type'];
        $inputGP = $this->request->getPost('params')['provider'];
        $inputCredit = $this->request->getPost('params')['credit'];

        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $inputGP,
            'ismobile' => (int)$this->request->getPost('params')['isMobile']
        ];
        $res = $this->game_model->selectGameLobby($payload);
        // echo json_encode($res);

        if( $res['code']==1 ):
            // Check latest 7 days score log
            $payloadScoreLog = $this->checkLatestSecoreLog();
            if( $payloadScoreLog['code']==1 ):
                // Non-Empty Score-log
                if( $payloadScoreLog['data']!=[] ):
                    // If not same as previous game
                    if( $payloadScoreLog['data'][0]['gameProviderCode']!=$inputGP ):
                        // Get latest game balance
                        $payloadGetBalance = [
                            'userid' => $_SESSION['token'],
                            'gameprovidercode' => $payloadScoreLog['data'][0]['gameProviderCode']
                        ];
                        $resGetBalance = $this->game_model->selectGameBalance($payloadGetBalance);
                        // End Get latest game balance

                        // Get Success and Game Maintenance bypass
                        if( $resGetBalance['code']==1 || $resGetBalance['code']==71 ):
                            // Transfer-out
                            $payloadTransferOut = [
                                'userid' => $_SESSION['token'],
                                'gameprovidercode' => $payloadScoreLog['data'][0]['gameProviderCode'],
                                'transfertype' => 2,
                                'amount' => (float)$resGetBalance['balance']
                            ];
                            $resTransferOut = $this->game_model->updateGameCredit($payloadTransferOut);
                            // End Transfer-out

                            // Transfer-in
                            $payloadScoreLog2 = $this->checkLatestSecoreLog();
                            if( $payloadScoreLog['code']==1 && $payloadScoreLog['data']!=[] ):
                                // Get if addition-balance
                                $latestProfile = $this->userProfile();
                                // End Get if addition-balance

                                $totalAmount = $latestProfile['data']['balance'] + $payloadScoreLog2['data'][0]['amount'];

                                $payloadTransferIn = [
                                    'userid' => $_SESSION['token'],
                                    'gameprovidercode' => $inputGP,
                                    'transfertype' => (int)$inputType,
                                    'amount' => (float)$totalAmount
                                ];
                                $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                                $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                                echo json_encode($result);
                            endif;
                            // End Transfer-in
                        else:
                            echo json_encode($resGetBalance);
                        endif;
                    // End If not same as previous game
                    else:
                        // If same as previous game
                        // Get if addition-balance
                        $latestProfile = $this->userProfile();
                        // End Get if addition-balance

                        $totalAmount = $latestProfile['data']['balance'];

                        // // Transfer-in
                        $payloadTransferIn = [
                            'userid' => $_SESSION['token'],
                            'gameprovidercode' => $inputGP,
                            'transfertype' => (int)$inputType,
                            'amount' => (float)$totalAmount
                        ];
                        $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                        $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                        echo json_encode($result);
                        // End Transfer-in
                        // End If same as previous game
                    endif;
                // Non-Empty Score-log
                else:
                    // Empty Score-log
                    // Transfer-in
                    $payloadTransferIn = [
                        'userid' => $_SESSION['token'],
                        'gameprovidercode' => $inputGP,
                        'transfertype' => (int)$inputType,
                        'amount' => (float)$inputCredit
                    ];
                    $resTransferIn = $this->game_model->updateGameCredit($payloadTransferIn);
                    $result = array_merge($resTransferIn, ['url'=>$res['url']]);
                    echo json_encode($result);
                    // End Transfer-in
                    // End Empty Score-log
                endif;
            else:
                echo json_encode($payloadScoreLog);
            endif;
            // End Check latest 7 days score log
        else:
            echo json_encode($res);
        endif;
    }

    public function transferGameCredit()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $this->request->getPost('params')['provider'],
            'transfertype' => (int)$this->request->getPost('params')['type'],
            'amount' => (float)$this->request->getPost('params')['credit']
        ];
        $res = $this->game_model->updateGameCredit($payload);
        echo json_encode($res);
    }

    public function getGameLobbyInfo()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'gameprovidercode' => $this->request->getPost('params')['provider'],
            'ismobile' => (int)$this->request->getPost('params')['isMobile']
        ];

        $res = $this->game_model->selectGameLobby($payload);
        echo json_encode($res);
    }

    /*
    Game Credit Log
    */

    public function gameCreditLog()
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

        $payload = $this->game_model->selectAllGameCreditLog([
            'userid' => $_SESSION['token'],
            'fromdate' => $from,
            'todate' => $to,
            'pageindex' => $raw['pageindex'],
            'rowperpage' => $raw['rowperpage'],
            'desc' => true
        ]);

        if( $payload['code']==1 && $payload['data']!=[] ):
            $data = [];
            foreach( $payload['data'] as $h ):
                switch($h['status']):
                    case 1: $status = lang('Label.success'); break;
                    case 2: $status = lang('Label.reject'); break;
                    case 3: $status = lang('Label.pending'); break;
                    case 4: $status = lang('Label.check'); break;
                    default: $status = '---';
                endswitch;

                switch($h['type']):
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
                    default: $type = '---';
                endswitch;

                $date = Time::parse(date('Y-m-d H:i:s', strtotime($h['createDate'])));
                $created = $date->toDateTimeString(); 

                $row = [];
                $row[] = $created;
                $row[] = $status;
                $row[] = $h['gameProviderName'];
                $row[] = $type;
                $row[] = $h['amount'];
                $data[] = $row;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>1, 'pageIndex'=>$payload['pageIndex'], 'rowPerPage'=>$payload['rowPerPage'], 'totalPage'=>$payload['totalPage'], 'totalRecord'=>$payload['totalRecord']]);
        else:
            echo json_encode(['no data']);
        endif;
    }

    /*
    Slot Game List
    */

    public function slotGamesList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);

        $provider = $this->request->getPost('params')['provider'];
        $payload = [
            'gameprovidercode' => $this->request->getPost('params')['provider']
        ];

        $res = $this->game_model->selectAllGames($payload);
		$keys = array_column($res['data'], 'order');
		array_multisort($keys, SORT_ASC, $res['data']);
        // echo json_encode($res);

        $i = 0;
        $game = '';
		if( $res['code']==1 && $res['data']!=[] ):
			foreach( $res['data'] as $g ):
                if ($i++ < 60)
                {
                if( $g['status']==1 ):
                    if( $data['session']==true ):
                        $game .= '<li class="col-xl-2 col-lg-2 col-md-2 col-4">';

                        // Original
                        // $game .= '<a class="d-block text-decoration-none overflow-hidden rounded-3" href="javascript:void(0);" onclick="singleGame(\''.$g['name'][$lng].'\',\''.$g['code'].'\',\''.$provider.'\');">';

                        // Instant Float Lobby
                        $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="singleGameLandingExpress(\'2\', \''.$g['name'][$lng].'\', \''.$provider.'\',\''.$g['code'].'\');">';

                        $game .= '<img class="w-100" src="'.$_ENV['gamecard'].'/'.$provider.'/'.$g['code'].'.png">';
                        $game .= '</a>';
                        $game .= '</li>';
                    else:
                        $game .= '<li class="col-xl-2 col-lg-2 col-md-2 col-4">';
                        $game .= '<a class="d-block text-decoration-none overflow-hidden rounded-3" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                        $game .= '<img class="w-100" src="'.$_ENV['gamecard'].'/'.$provider.'/'.$g['code'].'.png">';
                        $game .= '</a>';
                        $game .= '</li>';
                    endif;
                elseif( $g['status']==2 ):
                    $game .= '<li class="col-xl-2 col-lg-2 col-md-2 col-4 maintenance">';
                    $game .= '<a class="d-block text-decoration-none overflow-hidden rounded-3" href="javascript:void(0);">';
                    $game .= '<img class="w-100" src="'.$_ENV['gamecard'].'/'.$provider.'/'.$g['code'].'.png">';
                    $game .= '</a>';
                    $game .= '</li>';
                endif;
                }
			endforeach;
		endif;
		echo $game;
    }

    /*
    Game List
    */

    public function jokerAppGenerate()
    {
        $content = [
            'username' => $this->request->getPost('params')['gameid'],
            'password' => $this->request->getPost('params')['gamepass'],
            'time' => time(),
            'auto' => 1,
        ];

        $key = utf8_encode('EciWDXpWxyDbfC/QvS61qajkkKy5HZWSCEExJfnosP8=');
        $ivString  = base64_decode('o0MgGUB6UvNiYUODWXVYdg==');

        $data = utf8_encode(urldecode(http_build_query($content, '', '&')));
        $encryptedData = base64_encode(openssl_encrypt($data, 'aes-256-cbc', $key,OPENSSL_RAW_DATA, $ivString));

        echo json_encode([
            'code' => 1,
            'url' => 'joker://www.joker123.net/mobile?data='.$encryptedData
        ]);
    }

    public function slotMultiXListWithTransferBox()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];
        $multiple = $this->request->getPost('params')['room'];
        $count = strlen($multiple) + 1;
        $substr = '-'.$count;

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
            $keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		endif;

        $platform = $this->checkDevice();

        $imgPath = 'desktop';

        if( $platform['mobile']==true ):
            $imgPath = 'mobile';
        endif;

        $game = '';     
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
                // Filter 2x
                $room = $multiple.'X';
                $roomCode = substr($s['code'], $substr);
                if( $roomCode==$room ):

				if( $data['session']==true ):
                    if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='JKR2X' || $s['code']=='JKR5X' || $s['code']=='JKR10X' || $s['code']=='JKR20X' ):
                            $game .= '<div>';

                            if( $platform['platform']=='iOS' ):
                                $game .= '<a href="javascript:void(0);" onclick="gameTransferBox(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                            else:
                                if( $platform['mobile']==true ):
                                    // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                                    $game .= '<a href="javascript:void(0);" onclick="appTransferBox(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                else:
                                    // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                                    $game .= '<a href="javascript:void(0);" onclick="gameTransferBox(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                endif;
                            endif;

                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/'.$imgPath.'/slot/'.$multiple.'X/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            //$game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</div>';
                        else:
                            $game .= '<div>';

                            // Original
                            // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                            // Instant Lobby
                            // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                            // Instant Float Lobby
                            if( $s['code']!='EV8' && $s['code']!='EV82X' && $s['code']!='EV85X' && $s['code']!='EV810X' ):
                                $game .= '<a href="javascript:void(0);" onclick="gameTransferBox(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                            else:
                                $game .= '<a href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                            endif;
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/'.$imgPath.'/slot/'.$multiple.'X/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            //$game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</div>';
                        endif;
                    elseif( $s['category']==$gameType && $s['status']==2 ):
                        $game .= '<div class="maintenance">';
                        $game .= '<a href="javascript:void(0)">';
                        $game .= '<img src="'.$_ENV['gameProviderCard'].'/'.$imgPath.'/slot/'.$multiple.'X/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                        //$game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                        $game .= '</a>';
                        $game .= '</div>';
                    endif;
				else:
					foreach( $s['type'] as $stype ):
                        if( $stype['type']==$gameType && $s['status']==1 ):
                            $game .= '<div>';
                            $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/'.$imgPath.'/slot/'.$multiple.'X/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                            //$game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                            $game .= '</a>';
                            $game .= '</div>';
                        elseif( $stype['type']==$gameType && $s['status']==2 ):
                            $game .= '<div class="maintenance">';
                            $game .= '<a href="javascript:void(0)">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/'.$imgPath.'/slot/'.$multiple.'X/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                            //$game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                            $game .= '</a>';
                            $game .= '</div>';
                        endif;
					endforeach;
				endif;
                endif;
			endforeach;
		endif;
		echo $game;
    }

    //fishing
    public function slotFishingList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];
        $minigametype = $this->request->getPost('params')['minigametype'];
        $multiple = $this->request->getPost('params')['room'];
        $count = strlen($multiple) + 1; //2
        $substr = '-'.$count;//-2

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $platform = $this->checkDevice();

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
                // Filter 2x
                $room = $multiple.'X';
                $roomCode = substr($s['code'], $substr);
                $providercount = strlen($s['code']) - $count;

                if( $roomCode==$room ):

                    $providercode = substr($s['code'], 0, $providercount);

                    if( $data['session']==true ):
                        if( $s['category']==$gameType && $s['status']==1 ):
                            $payload = [
                                'gameprovidercode' => $providercode
                            ];
                    
                            $res = $this->game_model->selectAllGames($payload);
                            $keys = array_column($res['data'], 'order');
                            array_multisort($keys, SORT_ASC, $res['data']);

                            if( $res['code']==1 && $res['data']!=[] ):
                                foreach( $res['data'] as $g ):
                                    if( $g['status']==1 && $g['type']==$minigametype ):
                                        $game .= '<li class="col-xl-2 col-lg-2 col-md-2 col-4 d-flex rounded-4">';
                                        $game .= '<a class="d-block w-100 text-decoration-none hotgame rounded-4 my-auto overflow-hidden" href="javascript:void(0);" onclick="singleGameTransferBox(\'2\', \''.$g['name'][$lng].'\', \''.$providercode.'\',\''.$g['code'].'\',\''.$s['name'].'\');">';
                                        $game .= '<img class="w-100 h-auto rounded-4" src="'.$_ENV['gamecard'].'/'.$providercode.'/'.$g['code'].'.png">';
                                        $game .= '</a>';
                                        $game .= '</li>';
                                    elseif( $g['status']==2 && $g['type']==$minigametype ):
                                        $game .= '<li class="col-xl-2 col-lg-2 col-md-2 col-4 maintenance d-flex rounded-4">';
                                        $game .= '<a class="d-block w-100 text-decoration-none hotgame rounded-4 my-auto overflow-hidden" href="javascript:void(0);">';
                                        $game .= '<img class="w-100 h-auto rounded-4" src="'.$_ENV['gamecard'].'/'.$providercode.'/'.$g['code'].'.png">';
                                        $game .= '</a>';
                                        $game .= '</li>';
                                    endif;
                                endforeach;
                            endif;
                        endif;
                    else:
                        foreach( $s['type'] as $stype ):
                            if( $stype['type']==$gameType && $s['status']==1 ):
                                $payload = [
                                    'gameprovidercode' => $providercode
                                ];
                        
                                $res = $this->game_model->selectAllGames($payload);
                                $keys = array_column($res['data'], 'order');
                                array_multisort($keys, SORT_ASC, $res['data']);
                                if( $res['code']==1 && $res['data']!=[] ):
                                    foreach( $res['data'] as $g ):
                                        if( $g['status']==1 && $g['type']==$minigametype ):
                                            $game .= '<li class="col-xl-2 col-lg-2 col-md-2 col-4 d-flex rounded-4">';
                                            $game .= '<a class="d-block w-100 text-decoration-none hotgame rounded-4 my-auto overflow-hidden" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                            $game .= '<img class="w-100 h-auto rounded-4" src="'.$_ENV['gamecard'].'/'.$providercode.'/'.$g['code'].'.png">';
                                            $game .= '</a>';
                                            $game .= '</li>';
                                        elseif( $g['status']==2 && $g['type']==$minigametype ):
                                            $game .= '<li class="col-xl-2 col-lg-2 col-md-2 col-4 maintenance d-flex rounded-4">';
                                            $game .= '<a class="d-block w-100 text-decoration-none hotgame rounded-4 my-auto overflow-hidden" href="javascript:void(0);">';
                                            $game .= '<img class="w-100 h-auto rounded-4" src="'.$_ENV['gamecard'].'/'.$providercode.'/'.$g['code'].'.png">';
                                            $game .= '</a>';
                                            $game .= '</li>';
                                        endif;
                                    endforeach;
                                endif;
                            endif;
                        endforeach;
                    endif;
                endif;
            endforeach;
        endif;
		echo $game;
    }

    public function slotMultiXList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];
        $multiple = $this->request->getPost('params')['room'];
        $count = strlen($multiple) + 1;
        $substr = '-'.$count;

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $platform = $this->checkDevice();

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
                // Filter 2x
                $room = $multiple.'X';
                $roomCode = substr($s['code'], $substr);
                if( $roomCode==$room ):

				if( $data['session']==true ):
                    if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='JKR2X' || $s['code']=='JKR5X' || $s['code']=='JKR10X' || $s['code']=='JKR20X' ):
                            $game .= '<li class="col-12">';

                            if( $platform['platform']=='iOS' ):
                                $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                            else:
                                if( $platform['mobile']==true ):
                                    $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                else:
                                    $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                endif;
                            endif;

                            $game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</li>';
                        else:
                            $game .= '<li class="col-12">';

                            // Original
                            // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                            // Instant Lobby
                            // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                            // Instant Float Lobby
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                            $game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</li>';
                        endif;
                    elseif( $s['category']==$gameType && $s['status']==2 ):
                        $game .= '<li class="col-12 maintenance">';
                        $game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
                        $game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                        $game .= '</a>';
                        $game .= '</li>';
                    endif;
				else:
					foreach( $s['type'] as $stype ):
                        if( $s['code']!='MG8' && $s['code']!='PU8' && $s['code']!='PB' && $s['code']!='EV8' && $s['code']!='K9' && $s['code']!='GW' && $s['code']!='CSC' && $s['code']!='K9K' ):
                            if( $stype['type']==$gameType && $s['status']==1 ):
                                $game .= '<li class="col-12">';
                                $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                $game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                                $game .= '</a>';
                                $game .= '</li>';
                            elseif( $stype['type']==$gameType && $s['status']==2 ):
                                $game .= '<li class="col-12 maintenance">';
                                $game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
                                $game .= '<img class="d-block w-100" src="'.base_url('../assets/img/games/slot/'.$multiple.'x').'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                                $game .= '</a>';
                                $game .= '</li>';
                            endif;
                        endif;
					endforeach;
				endif;
                endif;
			endforeach;
		endif;
		echo $game;
    }

    public function slotList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];
        $isLobby = $this->request->getPost('params')['isLobby'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $platform = $this->checkDevice();

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
                if (!strpos($s['code'], '2X') && !strpos($s['code'], '5X') && !strpos($s['code'], '10X') && !strpos($s['code'], '20X')):
                    if( $data['session']==true ):
                        if( $s['category']==$gameType && $s['status']==1 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div>';
                                //App game Filter
                                if( $s['code']!='MG8' && $s['code']!='PU8' && $s['code']!='PB' && $s['code']!='EV8' && $s['code']!='K9' && $s['code']!='GW' && $s['code']!='CSC' && $s['code']!='K9K' ):
                                    $game .= '<a href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                else:
                                    $game .= '<a href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                endif;
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/mobile/slot/1X/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '</a>';
                                $game .= '</div>';
                            else:
                                if( $isLobby==1 ):
                                    $game .= '<div>';
                                    //App game Filter
                                    if( $s['code']!='MG8' && $s['code']!='PU8' && $s['code']!='PB' && $s['code']!='EV8' && $s['code']!='K9' && $s['code']!='GW' && $s['code']!='CSC' && $s['code']!='K9K' ):
                                        $game .= '<a href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                    else:
                                        $game .= '<a href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                    endif;
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/1X/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                    $game .= '</a>';
                                    $game .= '</div>';
                                else:
                                    $game .= '<div class="games-card">';
                                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="slot">';
                                    $game .= '</div>';
                                endif;
                            endif;
                            // Original
                            // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                            // Instant Lobby
                            // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                            // Instant Float Lobby
                        elseif( $s['category']==$gameType && $s['status']==2 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="maintenance">';
                                $game .= '<a href="javascript:void(0)">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/mobile/slot/1X/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '</a>';
                                $game .= '</div>';
                            else:
                                if( $isLobby==1 ):
                                    $game .= '<div class="maintenance">';
                                    //App game Filter
                                    if( $s['code']!='MG8' && $s['code']!='PU8' && $s['code']!='PB' && $s['code']!='EV8' && $s['code']!='K9' && $s['code']!='GW' && $s['code']!='CSC' && $s['code']!='K9K' ):
                                        $game .= '<a href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                    else:
                                        $game .= '<a href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                    endif;
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/1X/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                    $game .= '</a>';
                                    $game .= '</div>';
                                else:
                                    $game .= '<div class="games-card maintenance">';
                                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="slot">';
                                    $game .= '</div>';
                                endif;
                            endif;
                        endif;
                    else:
                        foreach( $s['type'] as $stype ):
                            if( $stype['type']==$gameType && $s['status']==1 ):
                                if( $platform['mobile']==true ):
                                    $game .= '<div>';
                                    $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/mobile/slot/1X/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '</a>';
                                    $game .= '</div>';
                                else:
                                    if( $isLobby==1 ):
                                        $game .= '<div>';
                                        $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                        $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/1X/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                        $game .= '</a>';
                                        $game .= '</div>';
                                    else:
                                        $game .= '<div class="games-card">';
                                        $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="slot">';
                                        $game .= '</div>';
                                    endif;
                                endif;
                            elseif( $stype['type']==$gameType && $s['status']==2 ):
                                if( $platform['mobile']==true ):
                                    $game .= '<div class="maintenance">';
                                    $game .= '<a href="javascript:void(0)">';
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/mobile/slot/1X/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '</a>';
                                    $game .= '</div>';
                                else:
                                    if( $isLobby==1 ):
                                        $game .= '<div class="maintenance">';
                                        $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                        $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/1X/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                        $game .= '</a>';
                                        $game .= '</div>';
                                    else:
                                        $game .= '<div class="games-card maintenance">';
                                        $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="slot">';
                                        $game .= '</div>';
                                    endif;
                                endif;
                            endif;
                        endforeach;
                    endif;
                endif;
			endforeach;
		endif;
		echo $game;
    }

    public function slotListMenu()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
                if (!strpos($s['code'], '2X') && !strpos($s['code'], '5X') && !strpos($s['code'], '10X') && !strpos($s['code'], '20X')):
                    if( $data['session']==true ):
                        if( $s['code']!='MG8' && $s['code']!='PU8' && $s['code']!='PB' && $s['code']!='EV8' && $s['code']!='K9' && $s['code']!='GW' && $s['code']!='CSC' && $s['code']!='K9K' ):
                            if( $s['category']==$gameType && $s['status']==1 ):
                                $game .= '<a href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/menu/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '</a>';
                            elseif( $s['category']==$gameType && $s['status']==2 ):
                                $game .= '<a class="maintenance" href="javascript:void(0)">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/menu/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '</a>';
                            endif;
                        endif;
                    else:
                        foreach( $s['type'] as $stype ):
                            if( $s['code']!='MG8' && $s['code']!='PU8' && $s['code']!='PB' && $s['code']!='EV8' && $s['code']!='K9' && $s['code']!='GW' && $s['code']!='CSC' && $s['code']!='K9K' ):
                                if( $stype['type']==$gameType && $s['status']==1 ):
                                    $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/menu/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '</a>';
                                elseif( $stype['type']==$gameType && $s['status']==2 ):
                                    $game .= '<a class="maintenance" href="javascript:void(0)">';
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/slot/menu/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '</a>';
                                endif;
                            endif;
                        endforeach;
                    endif;
                endif;
			endforeach;
		endif;
		echo $game;
    }

    public function casinoList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $platform = $this->checkDevice();

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
                        if( $platform['mobile']==true ):
                            $game .= '<div class="game-panel">';
                            $game .= '<div class="panel-desc">';
                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';
                            $game .= '<div class="btn-wrap">';
                            if( $s['code']=='PT2' || $s['code']=='PRG2' ):
                                $game .= '<a class="btn" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.desktop').'</a>';
                            else:
                                $game .= '<a class="btn" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.desktop').'</a>';
                            endif;
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="casino">';
                            $game .= '</div>';
                        endif;

                        // Original
						// $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Lobby
                        // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Float Lobby
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        if( $platform['mobile']==true ):
                            $game .= '<div class="game-panel maintenance">';
                            $game .= '<div class="panel-desc">';
                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';
                            $game .= '<div class="btn-wrap">';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card maintenance">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="casino">';
                            $game .= '</div>';
                        endif;
					endif;
				else:
					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '<p>'.$s['name'][$lng].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.desktop').'</a>';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="casino">';
                                $game .= '</div>';
                            endif;
						elseif( $stype['type']==$gameType && $s['status']==2 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel maintenance">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '<p>'.$s['name'][$lng].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card maintenance">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="casino">';
                                $game .= '</div>';
                            endif;
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function casinoListMenu()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='PT2' || $s['code']=='PRG2' ):
                            $game .= '<a href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        else:
                            $game .= '<a href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        endif;
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</a>';
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        $game .= '<a class="maintenance" href="javascript:void(0);">';
                        $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                        $game .= '</a>';
					endif;
				else:
					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
                            $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                            $game .= '</a>';
						elseif( $stype['type']==$gameType && $s['status']==2 ):
                            $game .= '<a class="maintenance" href="javascript:void(0);">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                            $game .= '</a>';
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function casinoListLobby()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $count = 1;

        $navBar = '';
        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
            $navBar .= '<div class="inner-top">';
            $navBar .= '<div class="container">';
            $navBar .= '<div class="games-nav tabNav">';
            $navBar .= '<h3>'.strtoupper(lang('Nav.casino')).'</h3>';
            $navBar .= '<ul>';

			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
                    if ( $count==1 ):
                        $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'].'</span></li>';
                    else:
                        $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'].'</span></li>';
                    endif;

                    if ( $count==1 ):
                        $game .= '<div id="'.$s['code'].'" class="tabContent">';
                    else:
                        $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                    endif;

                    $game .= '<div class="games-image">';
                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy"></img>';
                    $game .= '</div>';
                    $game .= '<div class="games-intro">';
                    $game .= '<div>';
                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="casino"></img>';

                    if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='PT2' || $s['code']=='PRG2' ):
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                        else:
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                        endif;
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        $game .= '<a class="maintenance btn w-100" href="javascript:void(0);">'.strtoupper(lang('Nav.playgame')).'</a>';
					endif;

                    $game .= '</div>';
                    $game .= '</div>';
                    $game .= '</div>';

                    $count++;
				else:
                    foreach( $s['type'] as $stype ):
                        if( $stype['type']==$gameType && $s['status']==1 ):
                            if ( $count==1 ):
                                $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'][$lng].'</span></li>';
                            else:
                                $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'][$lng].'</span></li>';
                            endif;

                            if ( $count==1 ):
                                $game .= '<div id="'.$s['code'].'" class="tabContent">';
                            else:
                                $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                            endif;

                            $game .= '<div class="games-image">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy"></img>';
                            $game .= '</div>';
                            $game .= '<div class="games-intro">';
                            $game .= '<div>';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="sport">';
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $count++;
                        elseif( $stype['type']==$gameType && $s['status']==2 ):
                            if ( $count==1 ):
                                $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'][$lng].'</span></li>';
                            else:
                                $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'][$lng].'</span></li>';
                            endif;

                            if ( $count==1 ):
                                $game .= '<div id="'.$s['code'].'" class="tabContent">';
                            else:
                                $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                            endif;

                            $game .= '<div class="games-image">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/casino/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy"></img>';
                            $game .= '</div>';
                            $game .= '<div class="games-intro">';
                            $game .= '<div>';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="sport">';
                            $game .= '<a href="javascript:void(0);" class="maintenance btn w-100">'.strtoupper(lang('Nav.playgame')).'</a>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $count++;
                        endif;
                    endforeach;
				endif;
			endforeach;

            $navBar .= '</ul>';
            $navBar .= '<div class="games-content">';
            $navBar .= '<div class="container">';
            $game .= '</div>';
            $game .= '</div>';
		endif;
		echo $navBar .= $game;
    }

    public function sportList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $platform = $this->checkDevice();

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
                        if( $platform['mobile']==true ):
                            $game .= '<div class="game-panel">';
                            $game .= '<div class="panel-desc">';
                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';
                            $game .= '<div class="btn-wrap">';

                            if( $s['code']=='OB3' || $s['code']=='RCB' ):
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.desktop').'</a>';
                            else:
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.desktop').'</a>';
                            endif;

                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="sport">';
                            $game .= '</div>';
                        endif;

                        // Original
						// $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Lobby
                        // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Float Lobby
                        // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        if( $platform['mobile']==true ):
                            $game .= '<div class="game-panel maintenance">';
                            $game .= '<div class="panel-desc">';
                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';
                            $game .= '<div class="btn-wrap">';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card maintenance">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="sport">';
                            $game .= '</div>';
                        endif;
					endif;
				else:
					foreach( $s['type'] as $stype ):
                        if( $stype['type']==3 && $s['status']==1 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '<p>'.$s['name'][$lng].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.desktop').'</a>';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="sport">';
                                $game .= '</div>';
                            endif;
                        else:
                            if( $stype['type']==$gameType && $s['status']==1 ):
                                if( $platform['mobile']==true ):
                                    $$game .= '<div class="game-panel">';
                                    $game .= '<div class="panel-desc">';
                                    $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '<p>'.$s['name'][$lng].'</p>';
                                    $game .= '<div class="btn-wrap">';
                                    $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.betnow').'</a>';
                                    $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.desktop').'</a>';
                                    $game .= '</div>';
                                    $game .= '</div>';
                                    $game .= '<div class="panel-img">';
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '</div>';
                                    $game .= '</div>';
                                else:
                                    $game .= '<div class="games-card">';
                                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="sport">';
                                    $game .= '</div>';
                                endif;
                            elseif( $stype['type']==$gameType && $s['status']==2 ):
                                if( $platform['mobile']==true ):
                                    $game .= '<div class="game-panel maintenance">';
                                    $game .= '<div class="panel-desc">';
                                    $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '<p>'.$s['name'][$lng].'</p>';
                                    $game .= '<div class="btn-wrap">';
                                    $game .= '</div>';
                                    $game .= '</div>';
                                    $game .= '<div class="panel-img">';
                                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                    $game .= '</div>';
                                    $game .= '</div>';
                                else:
                                    $game .= '<div class="games-card maintenance">';
                                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="sport">';
                                    $game .= '</div>';
                                endif;
                            endif;
                        endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function sportListMenu()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='OB3' || $s['code']=='RCB' ):
                            $game .= '<a href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';
                        else:
                            $game .= '<a href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        endif;
                        $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                        $game .= '</a>';
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        if( $platform['mobile']==true ):
                            $game .= '<div class="game-panel maintenance">';
                            $game .= '<div class="panel-desc">';
                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';
                            $game .= '<div class="btn-wrap">';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card maintenance">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="sport">';
                            $game .= '</div>';
                        endif;
					endif;
				else:
					foreach( $s['type'] as $stype ):
                        if( $stype['type']==3 && $s['status']==1 ):
                            $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                            $game .= '</a>';
                        else:
                            if( $stype['type']==$gameType && $s['status']==1 ):
                                $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</a>';
                            elseif( $stype['type']==$gameType && $s['status']==2 ):
                                $game .= '<a class="maintenance" href="javascript:void(0);">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</a>';
                            endif;
                        endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function sportListLobby()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $count = 1;

        $navBar = '';
        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
            $navBar .= '<div class="inner-top">';
            $navBar .= '<div class="container">';
            $navBar .= '<div class="games-nav tabNav">';
            $navBar .= '<h3>'.strtoupper(lang('Nav.sport')).'</h3>';
            $navBar .= '<ul>';

			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
                    if ( $count==1 ):
                        $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'].'</span></li>';
                    else:
                        $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'].'</span></li>';
                    endif;

                    if ( $count==1 ):
                        $game .= '<div id="'.$s['code'].'" class="tabContent">';
                    else:
                        $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                    endif;

                    $game .= '<div class="games-image">';
                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy"></img>';
                    $game .= '</div>';
                    $game .= '<div class="games-intro">';
                    $game .= '<div>';
                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="sport"></img>';

                    if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='OB3' || $s['code']=='RCB' ):
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                        else:
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                        endif;
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        $game .= '<a class="maintenance btn w-100" href="javascript:void(0);">'.strtoupper(lang('Nav.playgame')).'</a>';
					endif;

                    $game .= '</div>';
                    $game .= '</div>';
                    $game .= '</div>';

                    $count++;
				else:
                    foreach( $s['type'] as $stype ):
                        if( $stype['type']==$gameType && $s['status']==1 ):
                            if ( $count==1 ):
                                $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'][$lng].'</span></li>';
                            else:
                                $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'][$lng].'</span></li>';
                            endif;

                            if ( $count==1 ):
                                $game .= '<div id="'.$s['code'].'" class="tabContent">';
                            else:
                                $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                            endif;

                            $game .= '<div class="games-image">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy"></img>';
                            $game .= '</div>';
                            $game .= '<div class="games-intro">';
                            $game .= '<div>';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="sport">';
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $count++;
                        elseif( $stype['type']==$gameType && $s['status']==2 ):
                            if ( $count==1 ):
                                $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'][$lng].'</span></li>';
                            else:
                                $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'][$lng].'</span></li>';
                            endif;

                            if ( $count==1 ):
                                $game .= '<div id="'.$s['code'].'" class="tabContent">';
                            else:
                                $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                            endif;

                            $game .= '<div class="games-image">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/sport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy"></img>';
                            $game .= '</div>';
                            $game .= '<div class="games-intro">';
                            $game .= '<div>';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="sport">';
                            $game .= '<a href="javascript:void(0);" class="maintenance btn w-100">'.strtoupper(lang('Nav.playgame')).'</a>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '</div>';
                            $count++;
                        endif;
                    endforeach;
				endif;
			endforeach;

            $navBar .= '</ul>';
            $navBar .= '<div class="games-content">';
            $navBar .= '<div class="container">';
            $game .= '</div>';
            $game .= '</div>';
		endif;
		echo $navBar .= $game;
    }

    public function eSportList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $platform = $this->checkDevice();

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
                        if( $platform['mobile']==true ):
                            $game .= '<div class="game-panel">';
                            $game .= '<div class="panel-desc">';

                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';

                            $game .= '<div class="btn-wrap">';

                            $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.betnow').'</a>';
                            $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.desktop').'</a>';

                            $game .= '</div>';
                            $game .= '</div>';

                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/esport/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="esport">';
                            $game .= '</div>';
                        endif;

                        // Original
						// $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Lobby
                        // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Float Lobby
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        if( $platform['mobile']==true ):
                            $game .= '<div class="game-panel maintenance">';
                            $game .= '<div class="panel-desc">';

                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';

                            $game .= '<div class="btn-wrap">';
                            $game .= '</div>';
                            $game .= '</div>';

                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/esport/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card maintenance">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="esport">';
                            $game .= '</div>';
                        endif;
					endif;
				else:
					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '<p>'.$s['name'][$lng].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.desktop').'</a>';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/esport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="esport">';
                                $game .= '</div>';
                            endif;
						elseif( $stype['type']==$gameType && $s['status']==2 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel maintenance">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '<p>'.$s['name'][$lng].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/esport/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card maintenance">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="esport">';
                                $game .= '</div>';
                            endif;
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function lotteryList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $platform = $this->checkDevice();

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
						if( $s['code']=='GD8' || $s['code']=='MN8' || $s['code']=='GD2' ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '<p>'.$s['name'].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="lottoLanding(\'5\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="lottoLanding(\'5\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.desktop').'</a>';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="lottery">';
                                $game .= '</div>';
                            endif;
						elseif( $s['code']=='GD' || $s['code']=='GDS' ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '<p>'.$s['name'].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="lottoBonusLanding(\'6\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="lottoBonusLanding(\'6\', \''.$s['name'].'\', \''.$s['code'].'\');">'.lang('Label.desktop').'</a>';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="lottery">';
                                $game .= '</div>';
                            endif;
						endif;
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        if( $platform['mobile']==true ):
						    $game .= '<div class="game-panel maintenance">';
                            $game .= '<div class="panel-desc">';
                            $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '<p>'.$s['name'].'</p>';
                            $game .= '<div class="btn-wrap">';
                            $game .= '</div>';
                            $game .= '</div>';
                            $game .= '<div class="panel-img">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                            $game .= '</div>';
                            $game .= '</div>';
                        else:
                            $game .= '<div class="games-card maintenance">';
                            $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="lottery">';
                            $game .= '</div>';
                        endif;
					endif;
				else:
					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '<p>'.$s['name'][$lng].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '<a class="btn" style="white-space: nowrap;" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.betnow').'</a>';
                                $game .= '<a class="btn-outline" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.lang('Label.desktop').'</a>';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="lottery">';
                                $game .= '</div>';
                            endif;
						elseif( $stype['type']==$gameType && $s['status']==2 ):
                            if( $platform['mobile']==true ):
                                $game .= '<div class="game-panel maintenance">';
                                $game .= '<div class="panel-desc">';
                                $game .= '<img  src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '<p>'.$s['name'][$lng].'</p>';
                                $game .= '<div class="btn-wrap">';
                                $game .= '</div>';
                                $game .= '</div>';
                                $game .= '<div class="panel-img">';
                                $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                                $game .= '</div>';
                                $game .= '</div>';
                            else:
                                $game .= '<div class="games-card maintenance">';
                                $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="lottery">';
                                $game .= '</div>';
                            endif;
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function lotteryListMenu()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='GD8' || $s['code']=='MN8' || $s['code']=='GD2' ):
                            $game .= '<a href="javascript:void(0);" onclick="lottoLanding(\'5\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        elseif( $s['code']=='GD' || $s['code']=='GDS' ):
                            $game .= '<a href="javascript:void(0);" onclick="lottoBonusLanding(\'6\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        endif;
                        $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                        $game .= '</a>';
                    else:
                        $game .= '<a class="maintenance" href="javascript:void(0);">';
                        $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy">';
                        $game .= '</a>';
                    endif;
				else:
					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
                            $game .= '<a href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                            $game .= '</a>';
						elseif( $stype['type']==$gameType && $s['status']==2 ):
                            $game .= '<a class="maintenance" href="javascript:void(0);">';
                            $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy">';
                            $game .= '</a>';
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function lotteryListLobby()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $count = 1;

        $navBar = '';
        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
            $navBar .= '<div class="inner-top">';
            $navBar .= '<div class="container">';
            $navBar .= '<div class="games-nav tabNav">';
            $navBar .= '<h3>'.strtoupper(lang('Nav.lottery')).'</h3>';
            $navBar .= '<ul>';

			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
                    if ( $count==1 ):
                        $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'].'</span></li>';
                    else:
                        $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'].'</span></li>';
                    endif;

                    if ( $count==1 ):
                        $game .= '<div id="'.$s['code'].'" class="tabContent">';
                    else:
                        $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                    endif;

                    $game .= '<div class="games-image">';
                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy"></img>';
                    $game .= '</div>';
                    $game .= '<div class="games-intro">';
                    $game .= '<div>';
                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'" loading="lazy" cat="sport"></img>';

                    if( $s['category']==$gameType && $s['status']==1 ):
                        if( $s['code']=='GD8' || $s['code']=='MN8' || $s['code']=='GD2' ):
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="lottoLanding(\'5\', \''.$s['name'].'\', \''.$s['code'].'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                        elseif( $s['code']=='GD' || $s['code']=='GDS' ):
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="lottoBonusLanding(\'6\', \''.$s['name'].'\', \''.$s['code'].'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
                        endif;
					elseif( $s['category']==$gameType && $s['status']==2 ):
                        $game .= '<a class="maintenance btn w-100" href="javascript:void(0);">'.strtoupper(lang('Nav.playgame')).'</a>';
					endif;

                    $game .= '</div>';
                    $game .= '</div>';
                    $game .= '</div>';

                    $count++;
				else:
                    if ( $count==1 ):
                        $navBar .= '<li target="#'.$s['code'].'" class="cur"><span>'.$s['name'][$lng].'</span></li>';
                    else:
                        $navBar .= '<li target="#'.$s['code'].'"><span>'.$s['name'][$lng].'</span></li>';
                    endif;

                    if ( $count==1 ):
                        $game .= '<div id="'.$s['code'].'" class="tabContent">';
                    else:
                        $game .= '<div id="'.$s['code'].'" class="tabContent" style="display:none;">';
                    endif;

                    $game .= '<div class="games-image">';
                    $game .= '<img src="'.$_ENV['gameProviderCard'].'/desktop/lottery/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy"></img>';
                    $game .= '</div>';
                    $game .= '<div class="games-intro">';
                    $game .= '<div>';
                    $game .= '<img src="'.$_ENV['gameProviderLogo'].'/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'" loading="lazy" cat="sport">';

					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
                            $game .= '<a href="javascript:void(0);" class="btn w-100" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">'.strtoupper(lang('Nav.playgame')).'</a>';
						elseif( $stype['type']==$gameType && $s['status']==2 ):
                            $game .= '<a class="maintenance btn w-100" href="javascript:void(0);">'.strtoupper(lang('Nav.playgame')).'</a>';
						endif;
					endforeach;

                    $game .= '</div>';
                    $game .= '</div>';
                    $game .= '</div>';

                    $count++;
				endif;
			endforeach;

            $navBar .= '</ul>';
            $navBar .= '<div class="games-content">';
            $navBar .= '<div class="container">';
            $game .= '</div>';
            $game .= '</div>';
		endif;
		echo $navBar .= $game;
    }

    public function kenoList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
						$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-6">';

						// Original
						// $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Lobby
                        // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Float Lobby
                        // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                        if( $s['code']=='C93' ):
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';
                        else:
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        endif;

						$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/keno/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
						$game .= '</a>';
						$game .= '</li>';
					elseif( $s['category']==$gameType && $s['status']==2 ):
						$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-6 maintenance">';
						$game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
						$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/keno/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
						$game .= '</a>';
						$game .= '</li>';
					endif;
				else:
					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
							$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-6">';
							$game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \'Please login account\');">';
							$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/keno/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
							$game .= '</a>';
							$game .= '</li>';
						elseif( $stype['type']==$gameType && $s['status']==2 ):
							$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-6 maintenance">';
							$game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
							$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/keno/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
							$game .= '</a>';
							$game .= '</li>';
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function othersList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;
        
        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType && $s['status']==1 ):
						$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-12">';

						// Original
						// $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLanding(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Lobby
                        // $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="expressLobby(\''.$s['name'].'\', \''.$s['code'].'\');">';

                        // Instant Float Lobby
                        if( $s['code']=='PT2' || $s['code']=='PRG2' ):
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'2\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        else:
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="gameLandingExpress(\'1\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                        endif;

						$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/other/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
						$game .= '</a>';
						$game .= '</li>';
					elseif( $s['category']==$gameType && $s['status']==2 ):
						$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-12 maintenance">';
						$game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
						$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/other/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
						$game .= '</a>';
						$game .= '</li>';
					endif;
				else:
					foreach( $s['type'] as $stype ):
						if( $stype['type']==$gameType && $s['status']==1 ):
							$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-12">';
							$game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \'Please login account\');">';
							$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/other/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
							$game .= '</a>';
							$game .= '</li>';
						elseif( $stype['type']==$gameType && $s['status']==2 ):
							$game .= '<li class="col-xl-6 col-lg-6 col-md-6 col-12 maintenance">';
							$game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
							$game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/other/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
							$game .= '</a>';
							$game .= '</li>';
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function appGameList_OLD()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
			$provider = $this->gameprovider_model->selectAllGameProviders([]);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType ):
                        if( $s['status']==1 && ($s['code']=='MG8' || $s['code']=='PU8' || $s['code']=='PB' || $s['code']=='EV8' || $s['code']=='K9' || $s['code']=='GW' || $s['code']=='CSC') ):
                            $game .= '<li class="col-xl-3 col-lg-3 col-md-3 col-4">';
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                            $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</li>';
                        elseif( $s['status']==1 && $s['code']=='K9K' ):
                            $game .= '<li class="col-xl-3 col-lg-3 col-md-3 col-4">';
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="appUrlLanding(\'4\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                            $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</li>';
                        elseif( $s['status']==2 && ($s['code']=='MG8' || $s['code']=='PU8' || $s['code']=='PB' || $s['code']=='EV8' || $s['code']=='K9' || $s['code']=='GW' || $s['code']=='CSC' || $s['code']=='K9K') ):
                            $game .= '<li class="col-xl-3 col-lg-3 col-md-3 col-4 maintenance">';
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
                            $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</li>';
                        endif;
                    endif;
				else:
					foreach( $s['type'] as $stype ):
                        if( $stype['type']==$gameType ):
                            if( $s['code']=='MG8' || $s['code']=='PU8' || $s['code']=='PB' || $s['code']=='EV8' || $s['code']=='K9' || $s['code']=='GW' || $s['code']=='CSC' || $s['code']=='K9K' ):
                                if( $s['status']==1 ):
                                    $game .= '<li class="col-xl-3 col-lg-3 col-md-3 col-4">';
                                    $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                    $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                                    $game .= '</a>';
                                    $game .= '</li>';
                                elseif( $s['status']==2 ):
                                    $game .= '<li class="col-xl-3 col-lg-3 col-md-3 col-4 maintenance">';
                                    $game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
                                    $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                                    $game .= '</a>';
                                    $game .= '</li>';
                                endif;
                            endif;
                        endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }

    public function appGameList()
    {
        $data['session'] = session()->get('logged_in') ? true : false;

        $lng = strtoupper($_SESSION['lang']);
		$gameType = $this->request->getPost('params')['type'];

        if( $data['session']==true ):
			$provider = $this->reorderGameProviderAgentList(['type'=>$gameType]);
			$keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		else:
            $provider = $this->gameprovider_model->selectAllGameProviders([]);
            $keys = array_column($provider['data'], 'order');
			array_multisort($keys, SORT_ASC, $provider['data']);
		endif;

        $game = '';
		if( $provider['code']==1 && $provider['data']!=[] ):
			foreach( $provider['data'] as $s ):
				if( $data['session']==true ):
					if( $s['category']==$gameType ):
                        if( $s['status']==1 && ($s['code']=='MG8' || $s['code']=='PU8' || $s['code']=='PB' || $s['code']=='EV8' || $s['code']=='K9' || $s['code']=='GW' || $s['code']=='CSC') ):
                            $game .= '<li class="col-12">';
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="appLanding(\'3\', \''.$s['name'].'\', \''.$s['code'].'\');">';
                            $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</li>';
                        elseif( $s['status']==2 && ($s['code']=='MG8' || $s['code']=='PU8' || $s['code']=='PB' || $s['code']=='EV8' || $s['code']=='K9' || $s['code']=='GW' || $s['code']=='CSC' || $s['code']=='K9K') ):
                            $game .= '<li class="col-12 maintenance">';
                            $game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
                            $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'].'" alt="'.$s['name'].'">';
                            $game .= '</a>';
                            $game .= '</li>';
                        endif;
                    endif;
				else:
					foreach( $s['type'] as $stype ):
                        if( $stype['type']==$gameType ):
                            if( $s['code']=='MG8' || $s['code']=='PU8' || $s['code']=='PB' || $s['code']=='EV8' || $s['code']=='K9' || $s['code']=='GW' || $s['code']=='CSC' || $s['code']=='K9K' ):
                                if( $s['status']==1 ):
                                    $game .= '<li class="col-12">';
                                    $game .= '<a class="d-block text-decoration-none" href="javascript:void(0);" onclick="alertToast(\'text-bg-dark\', \''.lang('Validation.loginaccount').'\');">';
                                    $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                                    $game .= '</a>';
                                    $game .= '</li>';
                                elseif( $s['status']==2 ):
                                    $game .= '<li class="col-12 maintenance">';
                                    $game .= '<a class="d-block text-decoration-none" href="javascript:void(0)">';
                                    $game .= '<img class="d-block w-100" src="'.$_ENV['gameProviderCard'].'/slot/'.$s['code'].'.png" title="'.$s['name'][$lng].'" alt="'.$s['name'][$lng].'">';
                                    $game .= '</a>';
                                    $game .= '</li>';
                                endif;
                            endif;
                        endif;
					endforeach;
				endif;
			endforeach;
		endif;
		echo $game;
    }
}