<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Mail_control extends BaseController
{
    public function mailList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token']
        ];

        $res = $this->mail_model->selectAllMails($payload);
        // echo json_encode($res);

        if( $res['code'] == 1 && $res['data'] != [] ):
            $data = [];
            foreach( $res['data'] as $m ):
                switch($m['read']):
                    case 1: $read = 'Yes'; break;
                    case 2: $read = 'No'; break;
                    default: $read = '---';
                endswitch;

                $date = Time::parse(date('Y-m-d H:i:s', strtotime($m['createDate'])));
                $created = $date->toDateTimeString();

                $row = [];
                $row[] = $created;
                $row[] = $m['title'];
                $row[] = $m['content'];
                $data[] = $row;
            endforeach;
            echo json_encode(['data'=>$data]);
        else:
            echo json_encode(['no data']);
        endif;
    }
}