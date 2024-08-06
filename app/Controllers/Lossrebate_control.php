<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Lossrebate_control extends BaseController
{
    protected function checkLossRebate()
    {
        $payload = [
            'userid' => $_SESSION['token'],
            'timezone' => 8
        ];
        $res = $this->lossrebate_model->selectLossRebate($payload);
        return $res;
    }

    /*
    Redeem Loss Rebate
    */

    public function approveLossRebate()
    {
        $data = date('c', strtotime(date('Y-m-d',strtotime("-1 days"))));

        $lossRebate = $this->checkLossRebate();
        if( $lossRebate['code']==1 && $lossRebate['data']!=[] ):
            unset($lossRebate['code']);
            unset($lossRebate['message']);

            $data = [
                'userid' => $_SESSION['token'],
                'date' => $data,
                'ip' => $_SESSION['ip'],
                'followdate' => false
            ];
            $payload = array_merge($data, $lossRebate);
            $res = $this->lossrebate_model->updateLossRebate2($payload);
            echo json_encode($res);
        elseif( $lossRebate['code']==1 && $lossRebate['data']==[] ):
            echo json_encode([
                'code' => 22,
                'message' => 'You have redeem the rebate today'
            ]);
        else:
            echo json_encode($lossRebate);
        endif;
    }
}