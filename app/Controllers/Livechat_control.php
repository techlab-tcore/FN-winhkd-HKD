<?php

namespace App\Controllers;

class Livechat_control extends BaseController
{
    public function loginLiveChat()
    {
        $session = session()->get('logged_in') ? true : false;
        if( $session==true ):
            $payload = [
                'sessionid' => $_SESSION['session'],
                'userid' => $_SESSION['token']
            ];
        else:
            $payload = [
                'sessionid' => null,
                'userid' => null
            ];
        endif;

        $res = $this->livechat_model->updateLiveChat($payload);
        echo json_encode($res);
    }
}