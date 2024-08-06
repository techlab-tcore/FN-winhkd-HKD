<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\User_model;
use App\Models\Balance_model;
use App\Models\Bank_model;
use App\Models\Bankcard_model;
use App\Models\Vault_model;
use App\Models\Pgateway_model;
use App\Models\Gameprovider_model;
use App\Models\Game_model;
use App\Models\Promotion_model;
use App\Models\Banner_model;
use App\Models\Affiliate_model;
use App\Models\Afflossrebate_model;
use App\Models\Lossrebate_model;
use App\Models\Content_model;
use App\Models\Jackpot_model;
use App\Models\Support_model;
use App\Models\Sms_model;
use App\Models\Mail_model;
use App\Models\Livechat_model;
use App\Models\Announcement_model;
use App\Models\Fortunewheel_model;
use App\Models\Checkin_model;
use App\Models\Currency_model;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url','form','text','filesystem','date','array','email','language','security'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        // Libraries
		$session = \Config\Services::session();
		$language = \Config\Services::language();
		$security = \Config\Services::security();
		$validation =  \Config\Services::validation();

        //$browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		// $session = session();
        // $session->set('lang', $browserLang);

        !$session->lang ? $session->set('lang', 'en') : '';
        //!$session->lang ? $session->set('lang', $browserLang) : '';
		$language->setLocale($session->lang);

        // Models
        $this->user_model = new user_model();
        $this->balance_model = new balance_model();
        $this->bankcard_model = new bankcard_model();
        $this->bank_model = new bank_model();
        $this->vault_model = new vault_model();
        $this->pgateway_model = new pgateway_model();
        $this->gameprovider_model = new gameprovider_model();
        $this->game_model = new game_model();
        $this->promotion_model = new promotion_model();
        $this->banner_model = new banner_model();
        $this->affiliate_model = new affiliate_model();
        $this->afflossrebate_model = new afflossrebate_model();
        $this->lossrebate_model = new lossrebate_model();
        $this->content_model = new content_model();
        $this->jackpot_model = new jackpot_model();
        $this->support_model = new support_model();
        $this->sms_model = new sms_model();
        $this->mail_model = new mail_model();
        $this->livechat_model = new livechat_model();
        $this->announcement_model = new announcement_model();
        $this->fortunewheel_model = new fortunewheel_model();
        $this->checkin_model = new checkin_model();
        $this->currency_model = new currency_model();

        // Global Usage
        
        // IP
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}
		$session->set('ip', $ip);

        // Domain
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parsedUrl = parse_url($url);
        $session->set('affiliate', 'https://'.$parsedUrl['host'].'/RA');
    }

    public function checkDevice()
    {
        $device = $this->request->getUserAgent();
        $currentMobile = $device->isMobile();
		$currentPlatform = $device->getPlatform();
		$result = [
			'mobile' => $currentMobile,
			'platform' => $currentPlatform
		];
        return $result;
    }
}
