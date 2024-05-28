<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Promotion_control extends BaseController
{
    /*
    DIY Promotion
    */

    public function triggerDIYOpenGame()
    {
        if( !session()->get('logged_in') ): return false; endif;

        switch( $this->request->getPost('params')['provider'] ):
            case 'GDS': $diy = $_ENV['gds']; break;
            case 'GD': $diy = $_ENV['gd']; break;
        endswitch;

        $payload = [
            'userid' => $_SESSION['token'],
            'promotionid' => $diy,
            'amount' => (float)$this->request->getPost('params')['amount'],
            'ip' => $_SESSION['ip']
        ];
        $transfer = $this->promotion_model->updatePromotionDIY($payload);

        if( $transfer['code']==1 ):
            $payload2 = [
                'userid' => $_SESSION['token'],
                'gameprovidercode' => $this->request->getPost('params')['provider'],
                'ismobile' => filter_var($this->request->getPost('params')['isMobile'], FILTER_VALIDATE_BOOLEAN)
            ];
            $res = $this->game_model->selectGameLobby($payload2);
            echo json_encode($res);
        else:
            echo json_encode($transfer);
        endif;
    }

    /*
    Promotion
    */

    public function getPromotion()
    {
        // if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_ENV['host'],
            'promotionid' => base64_decode($this->request->getPost('params')['promoId'])
        ];
        $res = $this->promotion_model->selectPromotion($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            $data['id'] = base64_encode($res['data']['promotionId']);
            $data['title'] = $res['data']['title'][$lng];
            $data['content'] = $res['data']['content'][$lng];
            $data['img'] = $res['data']['thumbnail'][$lng];
            $data['start'] = $res['data']['startDate'];
            $data['end'] = $res['data']['endDate'];
            $data['continueClaim'] = $res['data']['afterClaim'];
            $data['player'] = $res['data']['playerDetail'];

            echo json_encode([
                'data' => $data,
                'code' => $res['code'],
                'message' => $res['message']
            ]);
        else:
            echo json_encode($res);
        endif;
    }

    public function userPromotionList()
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token'],
            'category' => (int)$this->request->getPost('params')['category'],
            'type' => (int)$this->request->getPost('params')['type']
        ];
        $res = $this->promotion_model->selectAllPromotions($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $p ):
                if( $p['status']==1 ):
                    $row = [];
                    $row['id'] = base64_encode($p['promotionId']);
                    $row['title'] = $p['title'][$lng];
                    $row['content'] = $p['content'][$lng];
                    $row['img'] = $p['thumbnail'][$lng];
                    $row['order'] = $p['order'];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        else:
            echo json_encode($res);
        endif;
    }

    public function promotionList()
    {
        // if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_ENV['host'],
            'category' => (int)$this->request->getPost('params')['category'],
            'type' => (int)$this->request->getPost('params')['type']
        ];
        $res = $this->promotion_model->selectAllPromotions($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $p ):
                if( $p['status']==1 ):
                    $row = [];
                    $row['id'] = base64_encode($p['promotionId']);
                    $row['title'] = $p['title'][$lng];
                    $row['content'] = $p['content'][$lng];
                    $row['img'] = $p['thumbnail'][$lng];
                    $row['order'] = $p['order'];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode(['data'=>$data, 'code'=>$res['code'], 'message'=>$res['message']]);
        else:
            echo json_encode($res);
        endif;
    }

    public function promotionRawList()
    {
        // if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_ENV['host'],
            'category' => (int)$this->request->getPost('params')['category'],
            'type' => (int)$this->request->getPost('params')['type']
        ];
        $res = $this->promotion_model->selectAllPromotions($payload);
        echo json_encode($res);
    }

    public function firstPromotion()
    {
        // if( !session()->get('logged_in') ): return false; endif;

        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_ENV['host'],
            'category' => 0,
            'type' => 1
        ];
        $res = $this->promotion_model->selectAllPromotions($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $minArr = min($res['data']);
            foreach($res['data'] as $p):
                $date = Time::parse(date('Y-m-d H:i:s', strtotime($p['startDate'])));
                $startDate = $date->toDateTimeString();

                $date2 = Time::parse(date('Y-m-d H:i:s', strtotime($p['endDate'])));
                $endDate = $date2->toDateTimeString();

                $date3 = Time::parse(date('Y-m-d H:i:s'));
                $today = $date3->toDateTimeString();

                if( $endDate>=$today ):
                    if( $p['order']==$minArr['order'] ):
                        $row = [];
                        $row['status'] = (int)$p['status'];
                        $row['order'] = (int)$p['order'];
                        $row['title'] = $p['title'][$lng];
                        $row['startDate'] = date('Y-m-d',strtotime($startDate));
                        $row['endDate'] = date('Y-m-d',strtotime($endDate));
                    endif;
                endif;
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $row
            ]);
        else:
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => []
            ]);
        endif;
    }
}