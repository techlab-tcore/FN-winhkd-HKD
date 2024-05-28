<?php

namespace App\Controllers;

class Support_control extends BaseController
{
    /*
    Live Chat
    */

    public function getLiveChat()
    {
        $payload = [
            'userid' => $_ENV['host']
        ];
        $res = $this->support_model->selectLiveChat($payload);
        echo json_encode($res);
    }

    /*
    Whatsapp
    */
    
    public function wsList()
    {
        $payload = [
            'userid' => $_ENV['host']
        ];
        $res = $this->support_model->selectAllWs($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $s ):
                if( $s['status']==1 ):
                    $row = [];
                    $row['name'] = $s['name'];
                    $row['whatsapp'] = $s['mobileNumber'];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $data
            ]);
        else:
            echo json_encode($res);
        endif;
    }

    public function wsRegisterList()
    {
        $payload = [
            'userid' => $_ENV['host']
        ];
        $res = $this->support_model->selectAllWs($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $s ):
                if( $s['status']==3 && !empty($s['mobileNumber']) ):
                    $row = [];
                    $row['name'] = $s['name'];
                    $row['whatsapp'] = $s['mobileNumber'];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $data
            ]);
        else:
            echo json_encode($res);
        endif;
    }
}