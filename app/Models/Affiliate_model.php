<?php namespace App\Models;

use CodeIgniter\Model;

class Affiliate_model extends Model
{
    protected $affList = 'http://10.148.0.8:38214/affiliate/getaffiliatelist2';
    protected $affHistory = 'http://10.148.0.8:38214/affiliate/getaffiliatehistory';

    protected $affDownlineList = 'http://10.148.0.8:38214/user/getaffiliatedownlinelist';

    public function __construct()
	{
		$this->db = db_connect();
	}

    public function selectAllAffiliateDownline($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->affDownlineList);
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

    public function selectAllAffiliateHistory($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->affHistory);
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

    public function selectAllAffiliates($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->affList);
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