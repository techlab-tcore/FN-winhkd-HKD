<?php namespace App\Models;

use CodeIgniter\Model;

class Sms_model extends Model
{
    protected $sms = 'https://transfer.winhkd.live/sms/sendsms';

    protected $whatsapp = 'https://verifyme.asia/api/create-message';

    public function __construct()
	{
		$this->db = db_connect();
	}

    public function insertWhatsapp($where)
	{       
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->whatsapp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appkey' => '0530a0ef-40d5-4553-be96-2cd71cb5a176',
                'authkey' => 'd5ZeO65LwyWLBjGcXbuazACbjXpVQdYoAgOKUtaLJ6FWa9Rj4g',
                'to' => $where['to'],
                'message' => $where['message'],
                'sandbox' => 'false'
            ),
          ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function insertSms($where)
	{
		$data = array_merge(['lang'=>$_SESSION['lang'], 'agentid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->sms);
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