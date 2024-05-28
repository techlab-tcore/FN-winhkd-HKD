<?php namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Affiliate_control extends BaseController
{
    public function getAffiliateDownlineList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $raw = json_decode(file_get_contents('php://input'),1);
        $level = $raw['level'];

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->affiliate_model->selectAllAffiliateDownline($payload);
        // echo json_encode($res);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            if( $level==1 ):
                if( $res['data']['data']!=[] ):
                    foreach( $res['data']['data'] as $dw ):
                        $affURL = $_SESSION['affiliate'].'/'.$dw['loginId'];
                        $row = [];
                        $row[] = $dw['downlineCount'];
                        $row[] = $dw['loginId'];
                        $row[] = '<button type="button" class="btn btn-secondary btn-sm" onclick="copyRegUrl(\''.$affURL.'\');">'.lang('Nav.share').'</button>';
                        $data[] = $row;
                    endforeach;
                endif;
            elseif( $level==2 ):
                if( $res['data']['data']!=[] ):
                    foreach( $res['data']['data'] as $dw ):
                        foreach( $dw['data'] as $dw2 ):
                            $affURL = $_SESSION['affiliate'].'/'.$dw2['loginId'];
                            $row = [];
                            $row[] = $dw2['downlineCount'];
                            $row[] = $dw2['loginId'];
                            $row[] = '<button type="button" class="btn btn-secondary btn-sm" onclick="copyRegUrl(\''.$affURL.'\');">'.lang('Nav.share').'</button>';
                            $data[] = $row;
                        endforeach;
                    endforeach;
                endif;
            elseif( $level==3 ):
                if( $res['data']['data']!=[] ):
                    foreach( $res['data']['data'] as $dw ):
                        foreach( $dw['data'] as $dw2 ):
                            foreach( $dw2['data'] as $dw3 ):
                                $affURL = $_SESSION['affiliate'].'/'.$dw3['loginId'];
                                $row = [];
                                $row[] = $dw3['downlineCount'];
                                $row[] = $dw3['loginId'];
                                $row[] = '<button type="button" class="btn btn-secondary btn-sm" onclick="copyRegUrl(\''.$affURL.'\');">'.lang('Nav.share').'</button>';
                                $data[] = $row;
                            endforeach;
                        endforeach;
                    endforeach;
                endif;
            elseif( $level==4 ):
                if( $res['data']['data']!=[] ):
                    foreach( $res['data']['data'] as $dw ):
                        foreach( $dw['data'] as $dw2 ):
                            foreach( $dw2['data'] as $dw3 ):
                                foreach( $dw3['data'] as $dw4 ):
                                    $affURL = $_SESSION['affiliate'].'/'.$dw4['loginId'];
                                    $row = [];
                                    $row[] = $dw4['downlineCount'];
                                    $row[] = $dw4['loginId'];
                                    $row[] = '<button type="button" class="btn btn-secondary btn-sm" onclick="copyRegUrl(\''.$affURL.'\');">'.lang('Nav.share').'</button>';
                                    $data[] = $row;
                                endforeach;
                            endforeach;
                        endforeach;
                    endforeach;
                endif;
            elseif( $level==5 ):
                if( $res['data']['data']!=[] ):
                    foreach( $res['data']['data'] as $dw ):
                        foreach( $dw['data'] as $dw2 ):
                            foreach( $dw2['data'] as $dw3 ):
                                foreach( $dw3['data'] as $dw4 ):
                                    foreach( $dw4['data'] as $dw5 ):
                                        $affURL = $_SESSION['affiliate'].'/'.$dw5['loginId'];
                                        $row = [];
                                        $row[] = $dw5['downlineCount'];
                                        $row[] = $dw5['loginId'];
                                        $row[] = '<button type="button" class="btn btn-secondary btn-sm" onclick="copyRegUrl(\''.$affURL.'\');">'.lang('Nav.share').'</button>';
                                        $data[] = $row;
                                    endforeach;
                                endforeach;
                            endforeach;
                        endforeach;
                    endforeach;
                endif;
            endif;
            echo json_encode(['data'=>$data, 'code'=>1]);
        else:
            echo json_encode(['no data']);
        endif;
    }

    public function getAffiliateList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->affiliate_model->selectAllAffiliates($payload);
        echo json_encode([
            'code'=>$res['code'],
            'count'=>$res['count']
        ]);
    }

    // Affiliate History
    public function affiliateHistory()
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

        $payload = $this->affiliate_model->selectAllAffiliateHistory([
            'userid' => $_SESSION['token'],
            'fromdate' => $from,
            'todate' => $to,
            'pageindex' => $raw['pageindex'],
            'rowperpage' => $raw['rowperpage'],
            'desc' => true
        ]);
        // echo json_encode($payload);

        if( $payload['code']==1 && $payload['data']!=[] ):
            // krsort($raw['data']);
            $data = [];
            foreach( $payload['data'] as $h ):
                if( $h['data2']!=[] ):
                    foreach( $h['data2'] as $gp ):
                        $date = Time::parse(date('Y-m-d H:i:s', strtotime($h['toDate'])), 'Asia/Kuala_Lumpur');
                        $created = $date->toDateTimeString(); 

                        $final_a2w = floor($gp['affiliateToWallet'] * 10000)/10000;
                        $final_a2b = floor($gp['affiliateToBalance'] * 10000)/10000;
                        $final_aff = floor($h['actualAffiliate'] * 10000)/10000;

                        $row = [];
                        $row[] = date('Y-m-d H:i:s', strtotime($created));
                        $row[] = $gp['gameProviderCode'];
                        $row[] = $final_aff;
                        $row[] = $final_a2w;
                        $row[] = $final_a2b;
                        $data[] = $row;
                    endforeach;
                endif;
            endforeach;
            echo json_encode([
                'data' => $data,
                'code' => 1,
                'pageIndex' => $payload['pageIndex'],
                'rowPerPage' => $payload['rowPerPage'],
                'totalPage' => $payload['totalPage'],
                'totalRecord' => $payload['totalRecord']
            ]);
        else:
            echo json_encode(['no data']);
        endif;
    }
}