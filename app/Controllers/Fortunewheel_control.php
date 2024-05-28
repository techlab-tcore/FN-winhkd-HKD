<?php namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Fortunewheel_control extends BaseController
{
    public function spinFortuneWheel()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'ip' => $_SESSION['ip']
        ];
        $res = $this->fortunewheel_model->updateFortuneWheel($payload);
        echo json_encode($res);
    }

    public function fortuneWheelTopList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token'],
            'fromdate' => date('c', strtotime(date('Y-m-d 00:00:00'))),
            'todate' => date('c', strtotime(date('Y-m-d 23:59:59'))),
            'pageindex' => 1,
            'rowperpage' => 10,
            'top' => 10
        ];
        $res = $this->fortunewheel_model->selectAllFortuneWheelTopList($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $f ):
                $row = [];
                $row['loginId'] = substr_replace($f['loginId'],"***",0,6);
                $row['displayName'] = $f['displayName'][$lng];
                $row['rewardsAmount'] = $f['rewardsAmount'];
                // $row['rewardType'] = $f['rewardType'];
                $data[] = $row;
            endforeach;
            echo json_encode(['code'=>$res['code'], 'message'=>$res['message'],'data'=>$data]);
        else:
            echo json_encode($res);
        endif;
    }

    public function fortuneWheel()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->fortunewheel_model->selectAllFortuneWheel($payload);
        if( $res['code']==1 && $res['data']!=[] ):
            $order = array_column($res['data'], 'order');
            array_multisort($order, SORT_ASC, $res['data']);

            $data = [];
            foreach( $res['data'] as $w ):
                $row = [];
                $row['id'] = $w['id'];
                $row['name'] = strtoupper($w['displayName'][$lng]);
                $row['order'] = $w['order'];
                $data[] = $row;
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