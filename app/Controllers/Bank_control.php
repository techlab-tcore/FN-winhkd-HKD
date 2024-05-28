<?php namespace App\Controllers;

class Bank_control extends BaseController
{
    public function bankList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token'],
            'paymentmethod' => 1,
            'status' => 1
        ];
        $res = $this->bank_model->bankList($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $b ):
                if( ($b['name'][$lng]!=='Cash Bank' || $b['name'][$lng]!=='Withdrawal Bank') && $b['status']==1 && $b['isMobile']==1 ):
                    $row = [];
                    $row['bank'] = base64_encode($b['bankId']);
                    $row['name'] = $b['name'][$lng];
                    $data[] = $row;
                endif;
            endforeach;
            $bank['data'] = $data;
        else:
            $bank['data'] = '';
        endif;
        $result = array_merge(['code'=>$res['code']],$bank);
        echo json_encode($result);
    }
}