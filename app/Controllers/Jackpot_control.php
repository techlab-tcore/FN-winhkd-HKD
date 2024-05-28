<?php namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Jackpot_control extends BaseController
{
    public function checkingJackpot()
    {
        unset($_SESSION['jackpot']);
        $payload = [
            'userid' => $_SESSION['token'],
            'amount' => 0,
            'type' => 4
        ];
        $res = $this->jackpot_model->updateJackpot($payload);
        echo json_encode($res);
    }

    public function runningBigPrizeJackpot()
    {
        unset($_SESSION['jackpot']);
        $payload = [
            'userid' => $_SESSION['token'],
            'amount' => 1,
            'type' => 5
        ];
        $res = $this->jackpot_model->updateJackpot($payload);
        echo json_encode($res);
    }
    
    public function triggerJackpot()
    {
        unset($_SESSION['jackpot']);
        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->jackpot_model->selectJackpot($payload);
        echo json_encode($res);
    }
}