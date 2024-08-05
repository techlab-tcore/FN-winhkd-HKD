<?php namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Content_control extends BaseController
{
    /*
    SEO
    */

    public function contentSeo()
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            // 'contentid' => $this->request->getpost('params')['contentid'], 
        ];
        $res = $this->content_model->selectAllContents($payload);
        // echo json_encode($res);

        if( $res['code'] == 1 && $res['data'] != [] ):
            $data = [];
            foreach( $res['data'] as $c ):
                $verify = substr($c['contentId'],0,3);
                if( $verify=='SEO' && $c['status']==true ):
                    $row = [];
                    $row['id'] = base64_encode($c['id']);
                    $row['contentId'] = $c['contentId'];
                    $row['title'] = $c['title'][$lng];
                    $row['image'] = $c['thumbnail'][$lng];
                    $row['content'] = $c['content'][$lng];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $data
            ]);
        else:
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => []
            ]);
        endif;
    }

    public function getPromoContent()
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'id' => base64_decode($this->request->getpost('params')['id']), 
        ];
        $res = $this->content_model->selectContent($payload);
        // echo json_encode($res);

        if( $res['code'] == 1 && $res['data'] != [] ):
            foreach( $res['data'] as $c ):
                $row = [];
                $row['contentId'] = $c['contentId'];
                $row['title'] = $c['title'][$lng];
                $row['image'] = $c['thumbnail'][$lng];
                $row['content'] = $c['content'][$lng];
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $row
            ]);
        else:
            echo json_encode($res);
        endif;
    }

    public function contentAffiliateLossRebate()
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            // 'contentid' => $this->request->getpost('params')['contentid'], 
        ];
        $res = $this->content_model->selectAllContents($payload);
        // echo json_encode($res);

        if( $res['code'] == 1 && $res['data'] != [] ):
            $data = [];
            foreach( $res['data'] as $c ):
                $verify = substr($c['contentId'],0,5);
                if( $verify=='AFFLB' ):
                    $data['id'] = base64_encode($c['id']);
                    $data['contentId'] = $c['contentId'];
                    $data['title'] = $c['title'][$lng];
                    $data['image'] = $c['thumbnail'][$lng];
                    $data['content'] = $c['content'][$lng];
                endif;
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $data
            ]);
        else:
            echo json_encode(['no data']);
        endif;
    }

    public function getPromoContentList()
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            // 'contentid' => $this->request->getpost('params')['contentid'], 
        ];
        $res = $this->content_model->selectAllContents($payload);
        // echo json_encode($res);

        if( $res['code'] == 1 && $res['data'] != [] ):
            $data = [];
            foreach( $res['data'] as $c ):
                $verify = substr($c['contentId'],0,3);
                if( $verify=='PRO' ):
                    $row = [];
                    $row['contentId'] = $c['contentId'];
                    $row['title'] = $c['title'][$lng];
                    $row['image'] = $c['thumbnail'][$lng];
                    $row['content'] = $c['content'][$lng];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $data
            ]);
        else:
            echo json_encode(['no data']);
        endif;
    }

    public function getInstruction()
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'id' => base64_decode($this->request->getpost('params')['id']), 
        ];
        $res = $this->content_model->selectContent($payload);
        // echo json_encode($res);

        if( $res['code'] == 1 && $res['data'] != [] ):
            foreach( $res['data'] as $c ):
                $row = [];
                $row['contentId'] = $c['contentId'];
                $row['title'] = $c['title'][$lng];
                $row['image'] = $c['thumbnail'][$lng];
                $row['content'] = $c['content'][$lng];
            endforeach;
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'data' => $row
            ]);
        else:
            echo json_encode($res);
        endif;
    }
}