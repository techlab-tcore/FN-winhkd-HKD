<?php namespace App\Models;

use CodeIgniter\Model;

class Checkin_model extends Model
{
    protected $checkIn = 'http://10.148.0.8:38214/checkin/get';
    protected $checkInList = 'http://10.148.0.8:38214/checkin/getlist';
    protected $triggerCheckIn = 'http://10.148.0.8:38214/checkin/trigger';

    public function __construct()
	{
		$this->db = db_connect();
	}

    public function updateCheckIn($where)
    {
        $data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
        $payload = json_encode($data);

        $ch = curl_init($this->triggerCheckIn);
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

    public function selectCheckIn($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->checkIn);
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

    public function selectAllCheckIn($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'sessionid'=>$_SESSION['session'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->checkInList);
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