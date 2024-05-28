<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Announcement_control extends BaseController
{
    public function announcementPopList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token'],
            'desc' => true
        ];
        $res = $this->announcement_model->selectAllAnnouncementList($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $a ):
                if( $a['popUp']==1 ):
                    $date = Time::parse(date('Y-m-d H:i:s', strtotime($a['createDate'])));
                    $created = $date->toDateTimeString();

                    $row = [];
                    $row['created'] = date('Y-m-d h:i A', strtotime($created));
                    $row['content'] = $a['content'][$lng];
                    $row['pop'] = $a['popUp'];
                    $data[] = $row;
                endif;
            endforeach;
            $annc['data'] = $data;
        else:
            $annc['data'] = '';
        endif;
        $result = array_merge(['code'=>$res['code']],$annc);
        echo json_encode($result);
    }

    public function announcementList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token'],
            'desc' => true
        ];
        $res = $this->announcement_model->selectAllAnnouncementList($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $a ):
                if( $a['popUp']!=1 ):
                    $date = Time::parse(date('Y-m-d H:i:s', strtotime($a['createDate'])));
                    $created = $date->toDateTimeString();

                    $row = [];
                    $row['created'] = date('Y-m-d h:i A', strtotime($created));
                    $row['content'] = $a['content'][$lng];
                    $row['pop'] = $a['popUp'];
                    $data[] = $row;
                endif;
            endforeach;
            $annc['data'] = $data;
        else:
            $annc['data'] = '';
        endif;
        $result = array_merge(['code'=>$res['code']],$annc);
        echo json_encode($result);
    }
}