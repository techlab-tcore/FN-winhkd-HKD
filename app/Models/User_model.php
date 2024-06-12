<?php namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    protected $userRegister = 'http://10.148.0.8:38214/user/register';
    protected $userLogin = 'http://10.148.0.8:38214/user/login';
    protected $userLogout = 'http://10.148.0.8:38214/user/logout';
    protected $userProfile = 'http://10.148.0.8:38214/user/getprofile';
    protected $editUserPass = 'http://10.148.0.8:38214/user/updatepassword';
    protected $editUser = 'http://10.148.0.8:38214/user/editprofile';
    protected $editUserPassReset = 'http://10.148.0.8:38214/user/resetpassword';

    protected $getProfileNoLogin = 'http://10.148.0.8:38214/user/getprofileby';

    protected $editUserVaultPin = 'http://10.148.0.8:38214/user/updatesafepassword';
    protected $userUpline = 'http://10.148.0.8:38214/user/getuplinename';
    protected $userUplineContact = 'http://10.148.0.8:38214/user/getuplinecontact';

    protected $user2ndPass = 'http://10.148.0.8:38214/user/checksecurepassword';
    private $compareUser2ndPass = 'http://10.148.0.8:38214/user/comparesecurepassword';
    private $editUser2ndPass = 'http://10.148.0.8:38214/user/updatesecurepassword';

    public function __construct()
	{
		$this->db = db_connect();
	}

    public function selectUserProfileWithNoSession($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->getProfileNoLogin);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function updateUser($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->editUser);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function selectUserUplineContact($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->userUplineContact);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function selectCompare2ndPassword($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->compareUser2ndPass);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function select2ndPassword($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->user2ndPass);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function updateUser2ndPassword($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->editUser2ndPass);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function updateUserPasswordReset($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->editUserPassReset);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function updateUserPasswordWithoutSession($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->editUserPassWithoutSession);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function updateUserPassword($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->editUserPass);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function selectUser($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->userProfile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function updateUserLogout($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->userLogout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function updateUserLogin($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->userLogin);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function insertNewUser($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'adminid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->userRegister);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}