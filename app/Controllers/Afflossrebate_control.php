<?php namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Afflossrebate_control extends BaseController
{
    /*
    Protected
    */

    protected function getAffLossRebateList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'timezone' => 8
        ];
        $res = $this->afflossrebate_model->selectAffLossRebateList($payload);
        unset($res['code']);
        unset($res['message']);
        return $res;
    }

    /*
    Settlement
    */

    public function proceedAffLossRebateSettlement()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $Listing = $this->getAffLossRebateList();
        if( $Listing['actualLoseRebate']>0 ):
            $data = [
                'userid' => $_SESSION['token'],
                'dapprove' => false
            ];
            $payload = array_merge($data,$Listing);
            $res = $this->afflossrebate_model->updateAffLossRebateSettlement($payload);
            echo json_encode($res);
        else:
            echo json_encode([
                'code' => 0,
                'message' => lang('Validation.noafflossrebate'),
            ]);
        endif;
    }

    public function affLossRebateList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'timezone' => 8
        ];
        $res = $this->afflossrebate_model->selectAffLossRebateList($payload);
        echo json_encode($res);
    }

    /*
    History
    */

    public function affLossRebateHistory()
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

        $payload = $this->afflossrebate_model->selectAllAffLossRebateHistory([
            'userid' => $_SESSION['token'],
            'fromdate' => $from,
            'todate' => $to,
            'dateby' => (int)$raw['dateby'],
            'pageindex' => $raw['pageindex'],
            'rowperpage' => $raw['rowperpage'],
            'desc' => true
        ]);
        // echo json_encode($payload);

        if( $payload['code']==1 && $payload['data']!=[] ):
            $data = [];
            foreach( $payload['data'] as $h ):
                switch( $h['status'] ):
                    case 1: $status = '<small class="badge bg-success fw-normal me-1">'.lang('Label.success').'</small>'; break;
                    default:
                        $status = '<small class="badge bg-danger fw-normal me-1">'.lang('Label.reject').'</small>';
                endswitch;

                $date = Time::parse(date('Y-m-d H:i:s', strtotime($h['createDate'])));
                $created = $date->toDateTimeString();

                $lossRebate = floor($h['actualLoseRebate'] * 10000)/10000;
                $cash = floor($h['toBalance'] * 10000)/10000;
                $chip = floor($h['toWallet'] * 10000)/10000;

                $row = [];
                $row[] = $created;
                $row[] = $h['maxLoseRebateDay'].'<small class="badge bg-primary fw-normal ms-1">'.$h['loseRebateId'].'</small>';
                $row[] = $status.bcdiv($lossRebate,1,2);
                $row[] = $cash;
                $row[] = $chip;
                $data[] = $row;
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