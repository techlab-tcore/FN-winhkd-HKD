<?php namespace App\Controllers;

class Vault_control extends BaseController
{
    public function transferVaultBalance()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'safepassword' => $this->request->getPost('params')['vaultpin'],
            'amount' => (float)$this->request->getPost('params')['amount']
        ];
        $res = $this->vault_model->updateVaultBalance($payload);
        echo json_encode($res);
    }

    public function modifyVaultPin()
    {
        if( !session()->get('logged_in') ): return false; endif;

        if( !isset($this->request->getPost('params')['pin']) || empty($this->request->getPost('params')['pin']) ):
            $pin = '';
        else:
            $pin = $this->request->getPost('params')['pin'];
        endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'password' => $pin,
            'newpassword' => $this->request->getPost('params')['cnewpin'],
            'resetpassword' => false
        ];

        $res = $this->vault_model->updateVaultPin($payload);
        echo json_encode($res);
    }

    public function checkVaultPin()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token']
        ];

        $res = $this->vault_model->selectVaultPin($payload);
        echo json_encode($res);
    }
}