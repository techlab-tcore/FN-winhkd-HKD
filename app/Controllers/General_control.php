<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class General_control extends BaseController
{
	/*
	Protected
	*/

	protected function getCurrency($code)
    {
        $payload = [
            'userid' => $_SESSION['token'],
            'code' => $code
        ];
        $res = $this->currency_model->selectCurrency($payload);
        return $res;
    }

	protected function bankList()
    {
        $payload = [
            'userid' => $_SESSION['token'],
            'paymentmethod' => 1,
            'status' => 1
        ];
        $res = $this->bank_model->bankList($payload);
        return $res;
    }

	protected function reorderGameProviderAgentList($type)
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->gameprovider_model->selectAllAgentGameProvider($payload);
        if( $res['code']==1 && $res['data']!=[] ):
            switch( $type['type'] ):
                case 33: $category = 3; break;
                default:
                    $category = $type['type'];
            endswitch;

            $data = [];
            foreach( $res['data'] as $g ):
                foreach( $g['type'] as $key=>$gtype ):
                    if( $gtype['type']==$category ):
                        if( $gtype['type']==3 ):
                            if( $g['code']!='RCB' && $type['type']==3 ):
                                $row = [];
                                $row['status'] = $g['status'];
                                $row['code'] = $g['code'];
                                $row['name'] = $g['name'][$lng];
                                $row['order'] = $g['order'];
                                $row['category'] = $gtype['type'];
                                $data[] = $row;
                            elseif( $g['code']=='RCB' && $type['type']==33 ):
                                $row = [];
                                $row['status'] = $g['status'];
                                $row['code'] = $g['code'];
                                $row['name'] = $g['name'][$lng];
                                $row['order'] = $g['order'];
                                $row['category'] = $gtype['type'];
                                $data[] = $row;
                            endif;
                        else:
                            $row = [];
                            $row['status'] = $g['status'];
                            $row['code'] = $g['code'];
                            $row['name'] = $g['name'][$lng];
                            $row['order'] = $g['order'];
                            $row['category'] = $gtype['type'];
                            $data[] = $row;
                        endif;
                    endif;
                endforeach;
            endforeach;
            $games['data'] = $data;
            $result = array_merge(['code'=>$res['code'], 'message'=>$res['message']],$games);
        else:
            $result = ['code'=>$res['code'], 'message'=>$res['message']];
        endif;
        return $result;
    }

	protected function getReadOnlyList()
    {
        $lng = strtoupper($_SESSION['lang']);

        $res = $this->content_model->selectAllContents([]);
        return $res;
    }

	protected function getPromotionRawList($cate,$type)
	{
		$lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_ENV['host'],
            'category' => (int)$cate,
            'type' => (int)$type
        ];
        return $this->promotion_model->selectAllPromotions($payload);
	}

	/*
	Public
	*/

    public function checkDevice()
    {
        $device = $this->request->getUserAgent();
        $currentMobile = $device->isMobile();
		$currentPlatform = $device->getPlatform();
		$result = [
			'mobile' => $currentMobile,
			'platform' => $currentPlatform
		];
        echo json_encode($result);
    }

	public function index_affiliateRegister($affiliate)
	{
		if( session()->get('logged_in') ): return redirect()->to(base_url()); endif;
		$data['secTitle'] = lang('Label.downlineregis');
		$lng = strtoupper($_SESSION['lang']);

		$data['session'] = session()->get('logged_in') ? true : false;
		$data['affiliate'] = $affiliate;

		echo view('template/start');
        echo view('whatsapp-affiliate-register', $data);
		echo view('template/end', $data);
	}
	//test
	public function index_affiliateSmsRegister($affiliate)
	{
		if( session()->get('logged_in') ): return redirect()->to(base_url()); endif;
		$data['secTitle'] = lang('Label.downlineregis');
		$lng = strtoupper($_SESSION['lang']);

		$data['session'] = session()->get('logged_in') ? true : false;
		$data['affiliate'] = $affiliate;

		echo view('template/start');
        echo view('sms-affiliate-register', $data);
		echo view('template/end', $data);
	}

	public function index_whatsappRegister()
	{
		if( session()->get('logged_in') ): return redirect()->to(base_url()); endif;
		$data['secTitle'] = lang('Nav.regisnow');
		$lng = strtoupper($_SESSION['lang']);

		$data['session'] = session()->get('logged_in') ? true : false;

		echo view('template/start');
        echo view('whatsapp-register', $data);
		echo view('template/end', $data);
	}
	//test
	public function index_smsRegister()
	{
		if( session()->get('logged_in') ): return redirect()->to(base_url()); endif;
		$data['secTitle'] = lang('Nav.regisnow');
		$lng = strtoupper($_SESSION['lang']);

		$data['session'] = session()->get('logged_in') ? true : false;

		echo view('template/start');
		echo view('template/header');
        echo view('sms-register', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

    public function index()
	{
		// if( session()->get('logged_in') ): return redirect()->to(base_url('lobby')); endif;
		$data['session'] = session()->get('logged_in') ? true : false;

		$lng = strtoupper($_SESSION['lang']);

		// Banner
		$resBanner = $this->banner_model->selectAllBanners([]);
		$banner = '';
		if( $resBanner['code']==1 && $resBanner['data']!=[] ):
			foreach( $resBanner['data'] as $indexBanner=>$bn ):
				if( $indexBanner>0 ):
					if( $bn['status'] == 1 ):
						$banner .= '<a href="javascript:void(0);"><img class="d-block w-100" src="'.$bn['imageUrl'][$lng].'" alt="'.$_ENV['company'].'" title="'.$_ENV['company'].'"></a>';
					endif;
				else:
					//$banner .= '<a class="swiper-slide home-banner p-2 pt-0" href="javascript:void(0);"><img class="d-block w-100 rounded-4" src="'.base_url('../assets/img/banner/defaultBanner.png').'" alt="'.$_ENV['company'].'" title="'.$_ENV['company'].'"></a>';
					$banner .= '';
				endif;
			endforeach;
		else:
			$banner .= '<a href="javascript:void(0);"><img class="d-block w-100" src="'.base_url('../assets/img/banner/defaultBanner.png').'" alt="'.$_ENV['company'].'" title="'.$_ENV['company'].'"></a>';
		endif;
		$data['banner'] = $banner;
		
		echo view('template/start');
		echo view('template/header',$data);
        echo view('index',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_login()
	{
		if( session()->get('logged_in') ): return redirect()->to(base_url()); endif;
		$data['session'] = session()->get('logged_in') ? true : false;

		$lng = strtoupper($_SESSION['lang']);
		
		echo view('template/start');
        echo view('login',$data);
		echo view('template/end',$data);
	}

	public function index_forgotPassword()
	{
		if( session()->get('logged_in') ): return redirect()->to(base_url()); endif;
		$data['session'] = session()->get('logged_in') ? true : false;

		$data['secTitle'] = lang('Nav.forgotpass');
		
		echo view('template/start');
		echo view('template/header');
        echo view('forgot-password', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	/*
	Transaction
	*/

	public function index_userCommission()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.affdownline');
		
		echo view('template/start');
		echo view('template/header');
        echo view('transaction/commission',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_affLossRebateLog()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.afflossrebatelog');
		
		echo view('template/start');
		echo view('template/header');
        echo view('transaction/afflossrebate-log', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_affiliateLog()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.afflog');
		
		echo view('template/start');
		echo view('template/header');
        echo view('transaction/aff-log', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_deposit()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.deposit');
		
		echo view('template/start');
		echo view('template/header');
        echo view('transaction/deposit', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_withdrawal()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.withdrawal');
		
		echo view('template/start');
		echo view('template/header');
        echo view('transaction/withdrawal',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_pgateway($pgid,$merchant)
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.deposit');

		$data['pgid'] = $pgid;
		$data['merchant'] = $merchant;

		// Payment Gateway
		// $payloadPG = [
        //     'userid' => $_SESSION['token']
        // ];
        // $resPG = $this->pgateway_model->pGatewayList($payloadPG);
		// $payGateway = '';
		// if( $resPG['code']==1 && $resPG['data']!=[] ):
        //     // $data['payGateway'] = json_encode($resPG);
		// 	foreach( $resPG['data'] as $p ):
		// 		if( $p['status']==1 ):
		// 			$row = [];
		// 			$row['bank'] = $p['bankName'][$lng];
		// 			$row['bankId'] = base64_encode($p['bankId']);
		// 			$row['merchant'] = $p['merchantCode'];
		// 			$row['apiKey'] = $p['apiKey'];
		// 		endif;
		// 	endforeach;
		// 	$data['payGateway'] = [
		// 		'code' => $resPG['code'],
		// 		'message' => $resPG['message'],
		// 		'data' => $row,
		// 	];
		// else:
		// 	$data['payGateway'] = [
		// 		'code' => $resPG['code'],
		// 		'message' => $resPG['message'],
		// 		'data' => [],
		// 	];
		// endif;

		echo view('template/start');
        echo view('transaction/pgateway',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_bankinfo($bank)
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.getbankinfo');

		// Company Bank Card
		$payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $res = $this->bankcard_model->companyBankCardList($payload);
        // echo json_encode($res);
		if( $res['code']==1 && $res['data']!=[] ):
			foreach( $res['data'] as $bc ):
				if( $bc['bankId']==base64_decode($bank) ):
					$data['bankId'] = base64_encode($bc['bankId']);
					$data['bankAccountNo'] = $bc['accountNo'];
					$data['bankCardNo'] = $bc['cardNo'];
					$data['holder'] = $bc['accountHolder'];
					$data['branch'] = $bc['branch'];
				endif;
			endforeach;
		else:
			$data['bankId'] = '---';
			$data['bankAccountNo'] = '---';
			$data['bankCardNo'] = '---';
			$data['holder'] = '---';
			$data['branch'] = '---';
		endif;

		echo view('template/start');
        echo view('transaction/bankinfo',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_banktransfer($bank)
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.deposit');

		// Company Bank Card
		$payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $res = $this->bankcard_model->companyBankCardList($payload);
		if( $res['code']==1 && $res['data']!=[] ):
			// Get Currency Code
			$currency = $this->bankList();
			foreach( $currency['data'] as $cd ):
				if( $cd['bankId']==base64_decode($bank) ):
					$code = $cd['currencyCode'][0];
				endif;
			endforeach;
			// End Get Currency Code

			$minDep = '';
			$maxDep = '';
			foreach( $res['data'] as $bc ):
				if( $bc['bankId']==base64_decode($bank) ):
					$minDep .= $bc['minDeposit'];
					$maxDep .= $bc['maxDeposit'];
				endif;
			endforeach;

			$data['compBankCardAvailable'] = true;
			$data['currency'] = $code;
			$data['bank'] = $bank;
			$data['minDeposit'] = $minDep;
			$data['maxDeposit'] = $maxDep;
		else:
			$data['compBankCardAvailable'] = false;
			$data['currency'] = $_ENV['currencyCode'];
			$data['bank'] = '';
			$data['minDeposit'] = 0;
			$data['maxDeposit'] = 0;
		endif;

		// Payment Gateway
		$payloadPG = [
            'userid' => $_SESSION['token']
        ];
        $resPG = $this->pgateway_model->pGatewayList($payloadPG);
		$payGateway = '';
		if( $resPG['code']==1 && $resPG['data']!=[] ):
            foreach( $resPG['data'] as $b ):
				$payGateway .= '<li class="col-xl-6 col-lg-6 col-md-12 col-12">';
				$payGateway .= '<a class="d-block text-decoration-none border bg-dark py-3 px-4" href="javascript:void(0);" onclick="preparePGChannel(\''.base64_encode($b['bankId']).'\',\''.$b['merchantCode'].'\')">';
				$payGateway .= '<span class="d-block pb-2 fs-4">'.$b['bankName'][$lng].' - '.lang('Nav.instanttransfer').'<i class="ms-1 img-badge hot"></i></span>';
				$payGateway .= '<img class="w-100" src="'.base_url('../assets/img/payment/'.$b['bankName'][$lng].'.png').'">';
				$payGateway .= '</a>';
				$payGateway .= '</li>';
            endforeach;
            $data['payGateway'] = $payGateway;
		else:
			$data['payGateway'] = '';
		endif;

		echo view('template/start');
        echo view('transaction/banktransfer',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_tngDepositFinal()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.deposit711qr');

		echo view('template/start');
        echo view('transaction/tngdeposit-final',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_tngDeposit($bank,$accno)
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		// Company Bank Card
		$payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $res = $this->bankcard_model->companyBankCardList($payload);
		if( $res['code']==1 && $res['data']!=[] ):
			// Get Currency Code
			$currency = $this->bankList();
			foreach( $currency['data'] as $cd ):
				if( $cd['bankId']==base64_decode($bank) ):
					$code = $cd['currencyCode'][0];
				endif;
			endforeach;

			$currencyRate = $this->getCurrency($code);
			if( $currencyRate['code']==1 && $currencyRate['data']!=[] ):
				$depositRate = $currencyRate['data']['depositRate'];
				$withdrawRate = $currencyRate['data']['withdrawalRate'];
			else:
				$depositRate = 1;
				$withdrawRate = 1;
			endif;
			$data['depositRate'] = $depositRate;
			$data['withdrawRate'] = $withdrawRate;
			// End Get Currency Code

			$comp711QrAvailabel = '';
			$accNo = '';
			$cardNo = '';
			$minDep = '';
			$maxDep = '';
			$qrUrl = '';
			foreach( $res['data'] as $bc ):
				if( $bc['status']==1 && $bc['display']==1 ):
					if( $bc['bankId']==base64_decode($bank) && $bc['accountNo']==$accno ):
						$comp711QrAvailabel .= true;
						$accNo .= $bc['accountNo'];
						$cardNo .= $bc['cardNo'];
						$minDep .= $bc['minDeposit'];
						$maxDep .= $bc['maxDeposit'];
						$qrUrl .= $bc['qrCodeUrl'];
						$bankName .= $bc['name'][$lng];
					endif;
				endif;
			endforeach;

			$data['comp711QrAvailabel'] = $comp711QrAvailabel;
			$data['currency'] = $code;
			$data['bank'] = $bank;
			$data['accNo'] = $accNo;
			$data['cardNo'] = $cardNo;
			$data['minDeposit'] = $minDep;
			$data['maxDeposit'] = $maxDep;
			$data['qrUrl'] = $qrUrl;
			$data['bankName'] = $bankName;
		else:
			$data['comp711QrAvailabel'] = false;
			$data['currency'] = $_ENV['currencyCode'];
			$data['bank'] = '';
			$data['accNo'] = '';
			$data['cardNo'] = '';
			$data['minDeposit'] = 0;
			$data['maxDeposit'] = 0;
			$data['qrUrl'] = '';
			$data['bankName'] = '';
		endif;

		$data['secTitle'] = $code=='MYR' ? $bankName: lang('Nav.deposit711qr');

		echo view('template/start');
        echo view('transaction/tngdeposit-1',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_711DepositFinal()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.deposit711qr');

		echo view('template/start');
        echo view('transaction/711deposit-final',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_711Deposit($bank,$accno)
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		// Company Bank Card
		$payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $res = $this->bankcard_model->companyBankCardList($payload);
		if( $res['code']==1 && $res['data']!=[] ):
			// Get Currency Code
			$currency = $this->bankList();
			foreach( $currency['data'] as $cd ):
				if( $cd['bankId']==base64_decode($bank) ):
					$code = $cd['currencyCode'][0];
				endif;
			endforeach;
			// End Get Currency Code

			$comp711QrAvailabel = '';
			$accNo = '';
			$cardNo = '';
			$minDep = '';
			$maxDep = '';
			$qrUrl = '';
			foreach( $res['data'] as $bc ):
				if( $bc['status']==1 && $bc['display']==1 ):
					if( $bc['bankId']==base64_decode($bank) && $bc['accountNo']==$accno ):
						$comp711QrAvailabel .= true;
						$accNo .= $bc['accountNo'];
						$cardNo .= $bc['cardNo'];
						$minDep .= $bc['minDeposit'];
						$maxDep .= $bc['maxDeposit'];
						$qrUrl .= $bc['qrCodeUrl'];
						$bankName .= $bc['name'][$lng];
					endif;
				endif;
			endforeach;

			$data['comp711QrAvailabel'] = $comp711QrAvailabel;
			$data['currency'] = $code;
			$data['bank'] = $bank;
			$data['accNo'] = $accNo;
			$data['cardNo'] = $cardNo;
			$data['minDeposit'] = $minDep;
			$data['maxDeposit'] = $maxDep;
			$data['qrUrl'] = $qrUrl;
			$data['bankName'] = $bankName;
		else:
			$data['comp711QrAvailabel'] = false;
			$data['currency'] = $_ENV['currencyCode'];
			$data['bank'] = '';
			$data['accNo'] = '';
			$data['cardNo'] = '';
			$data['minDeposit'] = 0;
			$data['maxDeposit'] = 0;
			$data['qrUrl'] = '';
			$data['bankName'] = '';
		endif;

		$data['secTitle'] = $code=='MYR' ? $bankName: lang('Nav.deposit711qr');

		echo view('template/start');
        echo view('transaction/711deposit-1',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_cryptoInfo($bank)
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.depositcrypto');

		// Company Bank Card
		$payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $res = $this->bankcard_model->companyBankCardList($payload);
        // $data['ss'] = json_encode($res);
		if( $res['code']==1 && $res['data']!=[] ):
			foreach( $res['data'] as $bc ):
				if( $bc['bankId']==base64_decode($bank) ):
					$data['bankId'] = base64_encode($bc['bankId']);
					$data['bankAccountNo'] = $bc['accountNo'];
					$data['bankCardNo'] = $bc['cardNo'];
					$data['holder'] = $bc['accountHolder'];
					$data['branch'] = $bc['branch'];
					$data['qrImg'] = $bc['qrCodeUrl'];
				endif;
			endforeach;
		else:
			$data['bankId'] = '---';
			$data['bankAccountNo'] = '---';
			$data['bankCardNo'] = '---';
			$data['holder'] = '---';
			$data['branch'] = '---';
			$data['qrImg'] = '---';
		endif;

		echo view('template/start');
        echo view('transaction/cryptoinfo',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_cryptoDeposit($bank)
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.depositcrypto');

		// Company Bank Card
		$payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $res = $this->bankcard_model->companyBankCardList($payload);
		if( $res['code']==1 && $res['data']!=[] ):
			// Get Currency Code
			$currency = $this->bankList();
			foreach( $currency['data'] as $cd ):
				if( $cd['bankId']==base64_decode($bank) ):
					$code = $cd['currencyCode'][0];
				endif;
			endforeach;

			$currencyRate = $this->getCurrency($code);
			if( $currencyRate['code']==1 && $currencyRate['data']!=[] ):
				$depositRate = $currencyRate['data']['depositRate'];
				$withdrawRate = $currencyRate['data']['withdrawalRate'];
			else:
				$depositRate = 1;
				$withdrawRate = 1;
			endif;
			$data['depositRate'] = $depositRate;
			$data['withdrawRate'] = $withdrawRate;
			// End Get Currency Code

			$minDep = '';
			$maxDep = '';
			foreach( $res['data'] as $bc ):
				if( $bc['bankId']==base64_decode($bank) ):
					$minDep .= $bc['minDeposit'];
					$maxDep .= $bc['maxDeposit'];
				endif;
			endforeach;

			$data['compBankCardAvailable'] = true;
			$data['currency'] = $code;
			$data['bank'] = $bank;
			$data['minDeposit'] = $minDep;
			$data['maxDeposit'] = $maxDep;
		else:
			$data['compBankCardAvailable'] = false;
			$data['currency'] = $_ENV['currencyCode'];
			$data['bank'] = '';
			$data['minDeposit'] = 0;
			$data['maxDeposit'] = 0;
		endif;

		echo view('template/start');
        echo view('transaction/crypto-deposit',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_paymenthod()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.deposit');

		// Bank Card
		$payload = [
            'agentid' => $_SESSION['token'],
            'userid' => $_ENV['host']
        ];
        $resBC = $this->bankcard_model->companyBankCardList($payload);
        $bc = '';
		if( $resBC['code']==1 && $resBC['data']!=[] ):
			// $data['bankCard'] = json_encode($resBC);
			foreach( $resBC['data'] as $b ):
				if( $b['status']==1 && $b['display']==1 ):
					// Currency
					$currency = $this->bankList();
					foreach( $currency['data'] as $cd ):
						if( $cd['bankId']==$b['bankId'] ):
							$code = $cd['currencyCode'][0];
						endif;
					endforeach;
					// End Currency

					if( $code!='USDT' ):
						if( empty($b['qrCodeUrl']) ):
							$bc .= '<li class="col-12">';
							$bc .= '<a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center btn-outline-secondary" href="'.base_url('deposit/bank-transfer/'.base64_encode($b['bankId'])).'">';
							$bc .= '<span class="d-inline-block position-relative icon-bank">'.$b['name'][$lng].' ('.lang('Input.atm').')</span><i class="bx bxs-right-arrow"></i>';
							$bc .= '</a>';
							$bc .= '</li>';
						else:
							// QR Payment
							if( $code!='HKD' ):
								if( $b['name'][$lng]=='TouchNGo' ):
									$bc .= '<li class="col-12">';
									$bc .= '<a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center btn-outline-secondary" href="'.base_url('deposit/tng-qr/'.base64_encode($b['bankId']).'/'.$b['accountNo']).'">';
									$bc .= '<span class="d-inline-block position-relative icon-tngqr">'.$b['name'][$lng].'</span><i class="bx bxs-right-arrow"></i>';
									$bc .= '</a>';
									$bc .= '</li>';
								endif;
							else:
								$bc .= '<li class="col-12">';
								$bc .= '<a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center btn-outline-secondary" href="'.base_url('deposit/711-qr/'.base64_encode($b['bankId']).'/'.$b['accountNo']).'">';
								$bc .= '<span class="d-inline-block position-relative icon-711qr">'.$b['name'][$lng].'</span><i class="bx bxs-right-arrow"></i>';
								$bc .= '</a>';
								$bc .= '</li>';
							endif;
							// End QR Payment
						endif;
					else:
						// Crypto
						$bc .= '<li class="col-12">';
						$bc .= '<a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center btn-outline-secondary" href="'.base_url('deposit/crypto/'.base64_encode($b['bankId'])).'">';
						$bc .= '<span class="d-inline-block position-relative icon-usdt">'.$b['name'][$lng].'</span><i class="bx bxs-right-arrow"></i>';
						$bc .= '</a>';
						$bc .= '</li>';
						// End Crypto
					endif;
				endif;
			endforeach;
			$data['bankCard'] = $bc;
		else:
			$data['bankCard'] = $bc;
		endif;

		// Payment Gateway
		$payloadPG = [
            'userid' => $_SESSION['token']
        ];
        $resPG = $this->pgateway_model->pGatewayList($payloadPG);
		$pg = '';
		if( $resPG['code']==1 && $resPG['data']!=[] ):
            // $data['payGateway'] = json_encode($resPG);
			foreach( $resPG['data'] as $p ):
				if( $p['status']==1 ):
					if( $p['bankId']==$_ENV['paypro'] ):
						$pg .= '<li class="col-12">';
						$pg .= '<a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center btn-outline-secondary" href="'.base_url('deposit/payment-gateway/'.base64_encode($p['bankId']).'/'.$p['merchantCode']).'">';
						//$pg .= '<span class="d-inline-block position-relative icon-fps">银行卡转账 / 转数快</span><i class="bx bx-chevron-right"></i>';
						$pg .= '<span class="d-inline-block position-relative icon-fps">'.lang('Label.banktransfer').'</span><i class="bx bxs-right-arrow"></i>';
						$pg .= '</a>';
						$pg .= '</li>';
					elseif( $p['bankId']==$_ENV['payessence'] ):
						$pg .= '<li class="col-12">';
						$pg .= '<a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center btn-outline-secondary" href="'.base_url('deposit/payment-gateway/'.base64_encode($p['bankId']).'/'.$p['merchantCode']).'">';
						$pg .= '<span class="d-inline-block position-relative icon-pg">'.$p['bankName'][$lng].'</span><i class="bx bxs-right-arrow"></i>';
						$pg .= '</a>';
						$pg .= '</li>';
					else:
						$pg .= '<li class="col-12">';
						$pg .= '<a class="d-block text-decoration-none p-xl-5 p-lg-5 p-md-5 p-3 rounded d-flex justify-content-between align-items-center btn-outline-secondary" href="'.base_url('deposit/payment-gateway/'.base64_encode($p['bankId']).'/'.$p['merchantCode']).'">';
						$pg .= '<span class="d-inline-block position-relative icon-bank">'.$p['bankName'][$lng].'</span><i class="bx bxs-right-arrow"></i>';
						$pg .= '</a>';
						$pg .= '</li>';
					endif;
				endif;
			endforeach;
			$data['payGateway'] = $pg;
		else:
			$data['payGateway'] = $pg;
		endif;

		echo view('template/start');
		echo view('template/header');
        echo view('transaction/paymethod',$data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_transactionHistory()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.history');
		
		echo view('template/start');
		echo view('template/header');
        echo view('transaction/index', $data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_scoreLog()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.scorelog');
		
		echo view('template/start');
		echo view('template/header');
        echo view('transaction/score-log', $data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	/*
	Personal
	*/

	public function index_account()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.account');
		
		echo view('template/start');
        echo view('personal/account', $data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_affDownline()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.downline');

		// Theme
		$payloadGeneral = $this->renderThemeGeneral();
		$payloadImgButton = $this->renderThemeImgButton();

		$header['logo'] = $payloadGeneral['data']['logo'];
		$data['img_loading'] = $payloadGeneral['data']['img_loading'];
		$theme['img_callapp'] = $payloadGeneral['data']['img_callapp'];
		$theme['color_body'] = $payloadGeneral['data']['color_body'];
		$theme['color_bg'] = $payloadGeneral['data']['color_background'];
		$theme['img_bg'] = $payloadGeneral['data']['img_background'];
		$theme['color_header'] = $payloadGeneral['data']['color_header'];
		$theme['img_header'] = $payloadGeneral['data']['header_img_background'];
		$theme['color_footer'] = $payloadGeneral['data']['color_footer'];
		$theme['img_footer'] = $payloadGeneral['data']['footer_img_background'];

		$theme['button_login'] = $payloadImgButton['data'][$lng]['btn_login'];
		$theme['button_register'] = $payloadImgButton['data'][$lng]['btn_register'];
		$theme['button_logout'] = $payloadImgButton['data'][$lng]['btn_logout'];
		$footer['button_footer_home'] = $payloadImgButton['data'][$lng]['btn_footer_home'];
		$footer['button_footer_share'] = $payloadImgButton['data'][$lng]['btn_footer_share'];
		$footer['button_footer_history'] = $payloadImgButton['data'][$lng]['btn_footer_history'];
		$footer['button_footer_account'] = $payloadImgButton['data'][$lng]['btn_footer_account'];
		$footer['button_footer_support'] = $payloadImgButton['data'][$lng]['btn_footer_support'];
		// End Theme
		
		echo view('template/start',$theme);
		echo view('template/header', $header);
        echo view('personal/aff-downline', $data);
		echo view('template/footer', $footer);
		echo view('template/end', $data);
	}

	public function index_mailbox()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.message');

		// Theme
		//$payloadGeneral = $this->renderThemeGeneral();
		//$payloadImgButton = $this->renderThemeImgButton();

		//$header['logo'] = $payloadGeneral['data']['logo'];
		//$data['img_loading'] = $payloadGeneral['data']['img_loading'];
		//$theme['img_callapp'] = $payloadGeneral['data']['img_callapp'];
		//$theme['color_body'] = $payloadGeneral['data']['color_body'];
		//$theme['color_bg'] = $payloadGeneral['data']['color_background'];
		//$theme['img_bg'] = $payloadGeneral['data']['img_background'];
		//$theme['color_header'] = $payloadGeneral['data']['color_header'];
		//$theme['img_header'] = $payloadGeneral['data']['header_img_background'];
		//$theme['color_footer'] = $payloadGeneral['data']['color_footer'];
		//$theme['img_footer'] = $payloadGeneral['data']['footer_img_background'];

		//$footer['button_footer_home'] = $payloadImgButton['data'][$lng]['btn_footer_home'];
		//$footer['button_footer_share'] = $payloadImgButton['data'][$lng]['btn_footer_share'];
		//$footer['button_footer_history'] = $payloadImgButton['data'][$lng]['btn_footer_history'];
		//$footer['button_footer_account'] = $payloadImgButton['data'][$lng]['btn_footer_account'];
		//$footer['button_footer_support'] = $payloadImgButton['data'][$lng]['btn_footer_support'];
		// End Theme
		
		echo view('template/start');
		echo view('template/header');
        echo view('personal/mailbox', $data);
		echo view('template/footer');
		echo view('template/end',$data);
	}

	public function index_password()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.password');
		
		echo view('template/start');
		echo view('template/header');
        echo view('personal/password', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_bankCard()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.bankacc');
		
		echo view('template/start');
		echo view('template/header');
        echo view('personal/bankcard', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_setupFirstBankCard()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.bankacc');

		// Theme
		$payloadGeneral = $this->renderThemeGeneral();
		$payloadImgButton = $this->renderThemeImgButton();

		$header['logo'] = $payloadGeneral['data']['logo'];
		$data['img_loading'] = $payloadGeneral['data']['img_loading'];
		$theme['img_callapp'] = $payloadGeneral['data']['img_callapp'];
		$theme['color_body'] = $payloadGeneral['data']['color_body'];
		$theme['color_bg'] = $payloadGeneral['data']['color_background'];
		$theme['img_bg'] = $payloadGeneral['data']['img_background'];
		$theme['color_header'] = $payloadGeneral['data']['color_header'];
		$theme['img_header'] = $payloadGeneral['data']['header_img_background'];
		$theme['color_footer'] = $payloadGeneral['data']['color_footer'];
		$theme['img_footer'] = $payloadGeneral['data']['footer_img_background'];
		// End Theme
		
		echo view('template/start',$theme);
        echo view('personal/initial-bankcard', $data);
		echo view('template/end', $data);
	}

	/*
	Game
	*/

	public function index_slot()
	{
		$data['session'] = session()->get('logged_in') ? true : false;

		$data['secTitle'] = lang('Nav.slot');
		
		echo view('template/start');
		echo view('template/header');
        echo view('games/slot', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_casino()
	{
		$data['session'] = session()->get('logged_in') ? true : false;

		$data['secTitle'] = lang('Nav.casino');

		echo view('template/start');
		echo view('template/header');
        echo view('games/casino', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_sport()
	{
		$data['session'] = session()->get('logged_in') ? true : false;

		$data['secTitle'] = lang('Nav.sport');

		echo view('template/start');
		echo view('template/header');
        echo view('games/sport', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	public function index_lottery()
	{
		$data['session'] = session()->get('logged_in') ? true : false;

		$data['secTitle'] = lang('Nav.lottery');

		echo view('template/start');
		echo view('template/header');
        echo view('games/lottery', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	/*
	Promotion
	*/

	public function index_promotion()
	{
		// if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Label.promotion');

		// Promotion
		$promotion = $this->getPromotionRawList(0,1);
		$keys = array_column($promotion['data'], 'order');
        array_multisort($keys, SORT_ASC, $promotion['data']);
		$allPromo = '';
		if( $promotion['code']==1 && $promotion['data']!=[] ):
			foreach( $promotion['data'] as $p ):
				$date = Time::parse(date('Y-m-d H:i:s', strtotime($p['startDate'])));
                $startDate = $date->toDateTimeString();

				$date2 = Time::parse(date('Y-m-d H:i:s', strtotime($p['endDate'])));
                $endDate = $date2->toDateTimeString();

				$date3 = Time::parse(date('Y-m-d H:i:s'));
                $today = $date3->toDateTimeString();

				if( $endDate>=$today ):
					$allPromo .= '<div class="promo-item">';
					$allPromo .= '<img class="promo-teaser-img" src="'.$p['thumbnail'][$lng].'" alt="'.$_ENV['company'].'" title="'.$_ENV['company'].'">';
					$allPromo .= '<div class="promo-teaser">';
					$allPromo .= '<h3>'.$p['title'][$lng].'</h3>';
					$allPromo .= '<p class="d-lg-none">'.lang('Label.longtermpromo').'</p>';
					$allPromo .= '<a class="btn viewPromoBtn" href="javascript:void(0);" onclick="getPromo(\''.base64_encode($p['promotionId']).'\');">'.strtoupper(lang('Nav.viewdetail')).'</a>';
					$allPromo .= '</div>';
					$allPromo .= '</div>';
				endif;
			endforeach;
			$data['allPromo'] = $allPromo;
		else:
			$data['allPromo'] = '';
		endif;
		

		// Read-Only Promotion
		$resReadOnly = $this->content_model->selectAllContents([]);
		$promoReadOnly = '';
		if( $resReadOnly['code'] == 1 && $resReadOnly['data'] != [] ):
			foreach( $resReadOnly['data'] as $r ):
				$verify = substr($r['contentId'],0,3);
				if( $verify=='PRO' && $r['status']==true ):
					$promoReadOnly .= '<div class="promo-item">';
					$promoReadOnly .= '<img class="promo-teaser-img" src="'.$r['thumbnail'][$lng].'" alt="'.$_ENV['company'].'" title="'.$_ENV['company'].'">';
					$promoReadOnly .= '<div class="promo-teaser">';
					$promoReadOnly .= '<h3>'.$r['title'][$lng].'</h3>';
					$promoReadOnly .= '<p class="d-lg-none">'.lang('Label.longtermpromo').'</p>';
					$promoReadOnly .= '<a class="btn viewPromoBtn" href="javascript:void(0);" onclick="getPromoReadOnly(\''.base64_encode($r['id']).'\');">'.strtoupper(lang('Nav.viewdetail')).'</a>';
					$promoReadOnly .= '</div>';
					$promoReadOnly .= '</div>';
                endif;
			endforeach;
			$data['promotionReadOnly'] = $promoReadOnly;
		else:
			$data['promotionReadOnly'] = '';
		endif;
		
		echo view('template/start');
		echo view('template/header');
        echo view('promotion/index', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	/*
	Instruction
	*/

	public function index_instruction()
	{
		// if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Label.tutorial');

		// Insrtuction List
		$resInstruct = $this->content_model->selectAllContents([]);
		$instructCard = '';
		if( $resInstruct['code'] == 1 && $resInstruct['data'] != [] ):
			foreach( $resInstruct['data'] as $r ):
				$verify = substr($r['contentId'],0,3);
				if( $verify=='INC' ):
					$instructCard .= '<li class="col-12">';

					$instructCard .= '<a class="d-block text-decoration-none overflow-hidden rounded-3" href="javascript:void(0);" onclick="getTutorial(\''.base64_encode($r['id']).'\');">';
					$instructCard .= '<h5 class="fw-normal m-0">'.$r['title'][$lng].'</h5>';
					$instructCard .= '</a>';

					$instructCard .= '</li>';
                endif;
			endforeach;
			$data['instructionCard'] = $instructCard;
		else:
			$data['instructionCard'] = '';
		endif;
		
		echo view('template/start');
        echo view('instruction/index', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	/*
	Fortune Wheel
	*/

	public function index_fortuneWheel()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;

		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Nav.fortunewheel');
		
		echo view('template/start');
        echo view('fortunewheel/index', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	/*
	Help
	*/

	public function index_help()
	{
		$data['session'] = session()->get('logged_in') ? true : false;
		$lng = strtoupper($_SESSION['lang']);

		$data['secTitle'] = lang('Label.help');
		
		echo view('template/start');
		echo view('template/header');
        echo view('help/index', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

	/*
	Safety Box
	*/

	public function index_vault()
	{
		if( !session()->get('logged_in') ): return false; endif;
		$data['session'] = session()->get('logged_in') ? true : false;

		$data['secTitle'] = lang('Nav.vault');
		
		echo view('template/start');
		echo view('template/header');
        echo view('personal/safetybox', $data);
		echo view('template/footer');
		echo view('template/end', $data);
	}

}
