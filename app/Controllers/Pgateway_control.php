<?php

namespace App\Controllers;

class Pgateway_control extends BaseController
{
    // public function paymentGatewayChannelList()
    // {
    //     if( !session()->get('logged_in') ): return false; endif;
    //     $lng = strtoupper($_SESSION['lang']);

    //     $payload = [
    //         'userid' => $_SESSION['token'],
    //         'bankid' => base64_decode($this->request->getPost('params')['bankid']),
    //         'merchantcode' => $this->request->getPost('params')['merchant'],
    //     ];

    //     $res = $this->pgateway_model->pGatewayChannelList($payload);
    //     // echo json_encode($res);
    //     if( $res['code']==1 && $res['data']!=[] ):
    //         $data = [];
    //         foreach( $res['data'] as $c ):
    //             if( $c['isDeposit']==1 ):
    //                 $row = [];
    //                 $row['code'] = $c['code'];
    //                 $row['channelName'] = $c['channelName'][$lng];
    //                 $row['charges'] = $c['charges'];
    //                 $row['minDeposit'] = $c['minDeposit'];
    //                 $row['maxDeposit'] = $c['maxDeposit'];
    //                 $row['minWithdrawal'] = $c['minWithdrawal'];
    //                 $row['maxWithdrawal'] = $c['maxWithdrawal'];
    //                 $row['maxDailyDeposit'] = $c['maxDailyDeposit'];
    //                 $row['maxDailyWithdrawal'] = $c['maxDailyWithdrawal'];
    //                 $row['accountId'] = $c['accountId'];
    //                 $row['bankCode'] = $c['bankCode'];
    //                 $data[] = $row;
    //             endif;
    //         endforeach;

    //         echo json_encode([
    //             'code' => $res['code'],
    //             'message' => $res['message'],
    //             'data' => $data
    //         ]);
    //     else:
    //         echo json_encode($res); 
    //     endif;
    // }

    /*
    Protected
    */

    protected function bankList()
    {
        $payload = [
            'userid' => $_SESSION['token'],
            'paymentmethod' => 2,
            'status' => 1
        ];
        $res = $this->bank_model->bankList($payload);
        return $res;
    }
    
    /*
    Public
    */

    public function paymentGatewayChannelList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'bankid' => base64_decode($this->request->getPost('params')['bankid']),
            'merchantcode' => $this->request->getPost('params')['merchant'],
        ];

        $res = $this->pgateway_model->pGatewayChannelList($payload);
        echo json_encode($res);
    }

    public function paymentGatewayList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $currency = $this->bankList();

        $payload = [
            'userid' => $_SESSION['token']
        ];

        $res = $this->pgateway_model->pGatewayList($payload);
        // echo json_encode($res);

        $data = [];
        if( $res['code']==1 && $res['data']!=[] ):
            foreach($res['data'] as $bc):
                $code = '';
                if( $bc['status']==1 && ($bc['bankId']!='654dc5339e104dbd4093d158') ):
                    foreach( $currency['data'] as $cd ):
                        if( $cd['bankId']==$bc['bankId'] ):
                            $code = $cd['currencyCode'][0];
                        endif;
                    endforeach;

                    $row = [];
                    $row['bank'] = $bc['bankId'];
                    $row['currency'] = $code;
                    $row['name'] = $bc['bankName'][$lng];
                    $row['merchant'] = $bc['merchantCode'];
                    $row['status'] = $bc['status'];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        else:
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        endif;
        // if( !session()->get('logged_in') ): return false; endif;

        // $payload = [
        //     'userid' => $_SESSION['token']
        // ];

        // $res = $this->pgateway_model->pGatewayList($payload);
        // echo json_encode($res);
    }
}