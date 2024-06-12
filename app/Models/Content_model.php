<?php namespace App\Models;

use CodeIgniter\Model;

class Content_model extends Model
{
    protected $contentList = 'http://10.148.0.8:38214/content/getlist';
    protected $content = 'http://10.148.0.8:38214/content/get';

    public function __construct()
	{
		$this->db = db_connect();
	}

    public function selectContent($where)
	{
        $data = array_merge(['lang'=>$_SESSION['lang'], 'adminid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->content);
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

    public function selectAllContents($where)
	{
        $data = array_merge(['lang'=>$_SESSION['lang'], 'adminid'=>$_ENV['host']], $where);
		$payload = json_encode($data);
        
        $ch = curl_init($this->contentList);
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