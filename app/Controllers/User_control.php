<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class User_control extends BaseController
{
    /*
	Protected
	*/

    protected function getProfileWithNoLogin($username)
    {
        $payload = [
            'loginid' => $username,
            'onlyactive' => true
        ];
        $res = $this->user_model->selectUserProfileWithNoSession($payload);
        return $res;
    }

    protected function checkLatestSecoreLog()
    {
        $earlier = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $from = date('c', strtotime(date('Y-m-d 00:00:00', strtotime($earlier))));
        $to = date('c', strtotime(date('Y-m-d 23:59:59')));

        $payload = [
            'userid' => $_SESSION['token'],
            'fromdate' => $from,
            'todate' => $to,
            'pageindex' => 1,
            'rowperpage' => 1,
            'desc' => true
        ];
        $res = $this->game_model->selectAllGameCreditLog($payload);
        return $res;
    }

    /*
    Support
    */

    public function userUplineContact()
    {
        $payload = [
            'userid' => $_ENV['host']
        ];
        $res = $this->user_model->selectUserUplineContact($payload);
        if( $res['code']==1 && $res['data']!=[] ):
            echo json_encode([
                'code' => $res['code'],
                'message' => $res['message'],
                'whatsapp' => !empty($res['data']['contact']) ? $_ENV['mobileCode'].$res['data']['contact'] : null,
                'telegram' => $res['data']['telegram'],
            ]);
        else:
            echo json_encode($res);
        endif;
    }

    /*
    User
    */
    
    public function compareSecondaryPassword()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'securepassword' => $this->request->getPost('params')['secondarypass']
        ];
        $res = $this->user_model->selectCompare2ndPassword($payload);
        echo json_encode($res);
    }

    public function checkSecondaryPassword()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->user_model->select2ndPassword($payload);
        echo json_encode($res);
    }

    public function modify2ndPassword()
    {
        if( !session()->get('logged_in') ): return false; endif;

        if( !isset($this->request->getPost('params')['current2ndpass']) || empty($this->request->getPost('params')['current2ndpass']) ):
            $current = '';
        else:
            $current = $this->request->getPost('params')['current2ndpass'];
        endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'password' => $current,
            'newpassword' => $this->request->getPost('params')['cnew2ndpass'],
            'resetpassword' => false
        ];
        $res = $this->user_model->updateUser2ndPassword($payload);
        echo json_encode($res);
    }

    public function modifyPassword()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'password' => $this->request->getPost('params')['currentpass'],
            'newpassword' => $this->request->getPost('params')['cnewpass'],
            'resetpassword' => false
        ];
        $res = $this->user_model->updateUserPassword($payload);
        echo json_encode($res);
    }

    public function resetPassword()
    {
        $payload = [
            'loginid' => $this->request->getpost('params')['username'],
            'contactno' => $this->request->getpost('params')['username'],
        ];
        $res = $this->user_model->updateUserPasswordReset($payload);
        echo json_encode($res);
    }

    public function modifyUserFullName()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $payload = [
            'userid' => $_SESSION['token'],
            'name' => $this->request->getpost('params')['fname'],
        ];
        $res = $this->user_model->updateUser($payload);
        echo json_encode($res);
    }

    public function getSelfBalance()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $res = $this->user_model->selectUser(['userid' => $_SESSION['token']]);
        if( $res['code']==1 && $res['data']!=[] ):
            $userBalance = floor($res['data']['balance'] * 100)/100;
            $vaultBalance = floor($res['data']['safeBalance'] * 100)/100;
            $fortuneToken = $res['data']['spinChip'];
            $jackpot = $res['data']['jackpot'];

            $createdAt = Time::parse(date('Y-m-d H:i:s', strtotime($res['data']['createDate'])), 'Asia/Kuala_Lumpur');

            $grandbgw = 0;
            $subgwamt = 0;
            $subgwafter = 0;
            $subgwTurnover = 0;
            foreach( $res['data']['gameWallet'] as $gw ):
                $subgwamt += $gw['amount'];
                $subgwafter += $gw['afterAmount'];
                $subgwTurnover += $gw['turnover'];
            endforeach;
            $grandbgw = $subgwamt - $subgwafter;

            $grandbw = 0;
            $subwamt = 0;
            $subwafter = 0;
            $subwTurnover = 0;
            foreach( $res['data']['wallet'] as $w ):
                $subwamt += $w['amount'];
                $subwafter += $w['afterAmount'];
                $subwTurnover += $w['turnover'];
            endforeach;
            $grandbw = $subwamt - $subwafter;

            $subPromoWallet = 0;
            foreach( $res['data']['playerPromotionWallet'] as $promoWallet ):
                $subPromoWallet += $promoWallet['amount'];
            endforeach;

            $grandcgw = 0;
            $subcgamt = 0;
            $subcgafter = 0;
            foreach( $res['data']['gpGroupWalletList'] as $cg ):
                $subcgamt += $cg['amount'];
                $subcgafter += $cg['afterAmount'];
            endforeach;
            $grandcgw = $subcgamt - $subcgafter;

            $subGameLotto = 0;
            foreach( $res['data']['gameWallet'] as $wglott ):
                if( $wglott['gameProviderCode']=='GD' || $wglott['gameProviderCode']=='GDS' || $wglott['gameProviderCode']=='GD8' || $wglott['gameProviderCode']=='MN8' ):
                    $subGameLotto += $wglott['amount'];
                endif;
            endforeach;

            $subWalletLotto = 0;
            foreach( $res['data']['wallet'] as $wlott ):
                if( $wlott['type']==5 ):
                    $subWalletLotto += $wlott['amount'];
                endif;
            endforeach;

            $grandcash = $res['data']['balance'] - ($grandbw + $grandbgw + $grandcgw);
            $grandchip = $grandbw + $grandbgw + $grandcgw;

            // $final_grandcash = floor($grandcash * 10000)/10000;
            $final_grandcash = $grandcash>0 ? floor($grandcash * 100)/100 : 0;
            $final_grandchip = floor($grandchip * 100)/100;

            $final_subGameLotto = floor($subGameLotto * 100)/100;
            $final_subWalletLotto = floor($subWalletLotto * 100)/100;

            // Turnover
            $totalCurrentTurnover = $subwafter + $subgwafter + $subPromoWallet;
            $totalTurnover = $res['data']['promotionTurnover'] + $subwTurnover + $subgwTurnover;

            $validCurrentTurnover = $totalCurrentTurnover > $totalTurnover ? 0 : $totalCurrentTurnover;
            // End Turnover

            $result = [
                'code' => $res['code'],
                'fullName' => $res['data']['name'],
                'balance' => $userBalance,
                'cash' => $final_grandcash,
                'chip' => $final_grandchip,
                'lotto' => $final_grandcash + $final_subGameLotto + $final_subWalletLotto,
                'vault' => $vaultBalance,
                'fortuneToken' => $fortuneToken,
                'jackpot' => $jackpot,
                'currentTurnover' => bcdiv($validCurrentTurnover,1,2),
                'totalTurnover' => bcdiv($totalTurnover,1,2),
                'registerDate' => $createdAt,
            ];
            echo json_encode($result);
        else:
            echo json_encode($res);
        endif;
    }

    public function getProfile()
    {
        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->user_model->selectUser($payload);
        echo json_encode($res);
    }

    public function login()
	{
        // $username = $_ENV['mobileCode'].preg_replace("/\s+/", "", strtolower($this->request->getpost('params')['username']));
        $username = preg_replace("/\s+/", "", strtolower($this->request->getpost('params')['username']));

        $payload = [
            'loginid' => $username,
            'password' => $this->request->getPost('params')['password'],
            'ip' => $_SESSION['ip'],
            'role' => 4
        ];
        $res = $this->user_model->updateUserLogin($payload);
        
        if( $res['code']==1 ):
            $session = session();
            $user_data = [
                'logged_in' => TRUE,
                'token' => $res['userId'],
                'session' => $res['sessionId'],
                'uplinerole' => $res['uplineRole'],
                'role' => $res['role'],
                'username' => strtolower($this->request->getPost('params')['username'])
            ];
            $session->set($user_data);

            $payloadScoreLog = $this->checkLatestSecoreLog();
            if( $payloadScoreLog['code']==1 && $payloadScoreLog['data']!=[] ):
                // Get leftover balance
                $payloadGetBalance = [
                    'userid' => $_SESSION['token'],
                    'gameprovidercode' => $payloadScoreLog['data'][0]['gameProviderCode']
                ];
                $resGetBalance = $this->game_model->selectGameBalance($payloadGetBalance);
                // Recall all the balance & update after-amount
                if( $resGetBalance['code']==1 ):
                    $payloadTransfer = [
                        'userid' => $_SESSION['token'],
                        'gameprovidercode' => $resGetBalance['gameProviderCode'],
                        'transfertype' => 2,
                        'amount' => (float)$resGetBalance['balance']
                    ];
                    $resTransfer = $this->game_model->updateGameCredit($payloadTransfer);
                    // echo json_encode($resTransfer);
                endif;
            endif;
        endif;
        echo json_encode($res);
    }

    public function forceLogout()
    {
        $session = session();
        $session->destroy();
        clearstatcache();
    }

    public function logout()
    {
        $session = session();
        $res = $this->user_model->updateUserLogout(['userid'=>$_SESSION['token']]);
        $session->destroy();
        clearstatcache();
        return redirect()->to(base_url());
    }

    public function affiliateRegistration()
    {
        if( session()->get('logged_in') ): return false; endif;

        // $firstChar = substr($this->request->getPost('params')['mobile'], 0, $_ENV['numMobileCode']);
        // if( $firstChar!=$_ENV['mobileCode'] ):
        //     echo json_encode([
        //         'code' => -1,
        //         'message' => lang('Validation.mobile')
        //     ]);
        // else:
            // Valid Mobile Number
            $inputUsername = $this->request->getpost('params')['username'];
            $inputCPass = $this->request->getpost('params')['password'];

            $getUID = $this->getProfileWithNoLogin($this->request->getpost('params')['affiliate']);
            // echo json_encode($getUID);
            $referrer = $getUID['data']['userId'];

            if( isset($_SESSION['taccode']) && $_SESSION['taccode']==$this->request->getpost('params')['veritac'] ):
                // Checking forbidden username - subaccount
                $subStandard = 'SUB';
                if( strpos($this->request->getPost('params')['mobile'], $subStandard)!== false ):
                    echo json_encode(['code'=>-1, 'message'=>lang('Validation.usernameforbidden')]);
                else:
                    // Checking forbidden username - agent or admin
                    $name = strtoupper($this->request->getpost('params')['mobile']);
                    if( $name=='AGENT' || $name=='ADMINISTRATOR' ):
                        echo json_encode(['code'=>-1, 'message'=>lang('Validation.usernameforbidden')]);
                    else:
                        $payload = [
                            'agentid' => $referrer,
                            'realname' => $this->request->getPost('params')['fname'],
                            'loginid'=> preg_replace("/\s+/", "", strtolower($inputUsername)),
                            'password'=> $inputCPass,
                            'name'=> strtoupper($this->request->getPost('params')['fname']),
                            //'contact'=> $_ENV['mobileCode'].preg_replace("/\s+/", "", $this->request->getPost('params')['mobile']),
                            'contact'=> preg_replace("/\s+/", "", $this->request->getPost('params')['mobile']),
                            'regionCode'=> $this->request->getPost('params')['regionCode'],
                            'gender' => 1,
                            'role'=> 4 // Member
                        ];
                        $res = $this->user_model->insertNewUser($payload);
                        // Login
                        if( $res['code']==1 ):
                            $resLogin = $this->user_model->updateUserLogin([
                                'loginid' => strtolower($inputUsername),
                                'password' => $inputCPass,
                                'ip' => $_SESSION['ip'],
                                'role' => 4
                            ]);

                            if( $resLogin['code']==1 ):
                                $session = session();
                                $user_data = [
                                    'logged_in' => TRUE,
                                    'token' => $resLogin['userId'],
                                    'session' => $resLogin['sessionId'],
                                    'uplinerole' => $resLogin['uplineRole'],
                                    'role' => $resLogin['role'],
                                    'username' => strtolower($inputUsername)
                                ];
                                $session->set($user_data);
                            endif;
                            echo json_encode($resLogin);
                        else:
                            echo json_encode($res);
                        endif;
                    endif;
                    // Checking forbidden username - agent or admin
                endif;
                // Checking forbidden username - subaccount
            else:
                unset($_SESSION['taccode']);
                echo json_encode(['code'=>-1, 'message'=>lang('Validation.smstac')]);
            endif;
            // End Valid Mobile Number
        // endif;
    }

    public function userRegistration()
    {
        if( session()->get('logged_in') ): return false; endif;

        $rules = [
            'params.password' => ['label'=>'Password','rules'=>'required|min_length[6]|max_length[15]'],
        ];

        // Checking Mobile Number
        // $firstChar = substr($this->request->getPost('params')['mobile'], 0, $_ENV['numMobileCode']);
        // if( $firstChar==$_ENV['mobileCode'] ):
        //     // $str = ltrim($this->request->getPost('params')['mobile'], '6');
        //     echo json_encode([
        //         'code' => -1,
        //         'message' => lang('Validation.mobile')
        //     ]);
        // else:
            // Valid Mobile Number
            $inputUsername = $this->request->getpost('params')['username'];
            $inputCPass = $this->request->getpost('params')['password'];

            if( isset($_SESSION['taccode']) && $_SESSION['taccode']==$this->request->getpost('params')['veritac'] ):
                // Checking forbidden username - subaccount
                $subStandard = 'SUB';
                if( strpos($this->request->getPost('params')['mobile'], $subStandard)!== false ):
                    echo json_encode(['code'=>-1, 'message'=>lang('Validation.usernameforbidden')]);
                else:
                    // Checking forbidden username - agent or admin
                    $name = strtoupper($this->request->getpost('params')['mobile']);
                    if( $name=='AGENT' || $name=='ADMINISTRATOR' ):
                        echo json_encode(['code'=>-1, 'message'=>lang('Validation.usernameforbidden')]);
                    else:
                        if( $this->validate($rules) ):
                            $payload = [
                                'agentid' => $_ENV['host'],
                                'realname' => $this->request->getPost('params')['fname'],
                                'loginid'=> preg_replace("/\s+/", "", strtolower($inputUsername)),
                                'password'=> $inputCPass,
                                'name'=> strtoupper($this->request->getPost('params')['fname']),
                                //'contact'=> $_ENV['mobileCode'].preg_replace("/\s+/", "", $this->request->getPost('params')['mobile']),
                                'contact'=> preg_replace("/\s+/", "", $this->request->getPost('params')['mobile']),
                                'regionCode'=> $this->request->getPost('params')['regionCode'],
                                'gender' => 1,
                                'role'=> 4 // Member
                            ];
                            $res = $this->user_model->insertNewUser($payload);
                            // Login
                            if( $res['code']==1 ):
                                $resLogin = $this->user_model->updateUserLogin([
                                    'loginid' => strtolower($inputUsername),
                                    'password' => $inputCPass,
                                    'ip' => $_SESSION['ip'],
                                    'role' => 4
                                ]);

                                if( $resLogin['code']==1 ):
                                    $session = session();
                                    $user_data = [
                                        'logged_in' => TRUE,
                                        'token' => $resLogin['userId'],
                                        'session' => $resLogin['sessionId'],
                                        'uplinerole' => $resLogin['uplineRole'],
                                        'role' => $resLogin['role'],
                                        'username' => strtolower($inputUsername)
                                    ];
                                    $session->set($user_data);
                                endif;
                                echo json_encode($resLogin);
                            else:
                                echo json_encode($res);
                            endif;
                        else:
                            echo json_encode([
                                'code' => -1,
                                'message' => $this->validator->getError('params.password')
                            ]);
                        endif;
                    endif;
                endif;
            else:
                unset($_SESSION['taccode']);
                echo json_encode(['code'=>-1, 'message'=>lang('Validation.smstac')]);
            endif;
        // endif;
    }

    public function forgotPassword()
    {
        if( session()->get('logged_in') ): return false; endif;

        // Checking Mobile Number
        //$firstChar = substr($this->request->getPost('params')['mobile'], 0, 1);
        //if( $firstChar=='6' ):
            // $str = ltrim($this->request->getPost('params')['mobile'], '6');
        //    echo json_encode([
        //        'code' => -1,
        //        'message' => lang('Validation.mobile')
        //    ]);
        //else:
            // Valid Mobile Number
            $userBeforeLogin = $this->getUserBeforeLogin($this->request->getpost('params')['mobile'], $this->request->getpost('params')['regionCode']);
            $inputMobile = $this->request->getpost('params')['mobile'];
            $inputUsername = strtolower($userBeforeLogin['data']['loginId']);
            $inputCPass = $this->request->getpost('params')['cnewpass'];

            if( isset($_SESSION['taccode']) && $_SESSION['taccode']==$this->request->getpost('params')['veritac'] ):
            // Reset Current Password
            $payload = [
                'loginid' => $inputUsername,
                'contactno' => $inputMobile,
            ];
            $res = $this->user_model->updateUserPasswordReset($payload);
            // echo json_encode($res);
            
                // Update New Password
                if( $res['code']==1 && !empty($res['userId']) && !empty($res['password']) ):
                    $payloadUpdate = [
                        'userid' => $res['userId'],
                        'password' => $res['password'],
                        'newpassword' => $inputCPass,
                        'resetpassword' => false
                    ];
                    $resUpdate = $this->user_model->updateUserPasswordWithoutSession($payloadUpdate);
                    echo json_encode($resUpdate);
                else:
                    echo json_encode($res);
                endif;
            else:
                unset($_SESSION['taccode']);
                echo json_encode(['code'=>-1, 'message'=>lang('Validation.smstac')]);
            endif;
        //endif;
    }


    public function tac()
    {
        $session = session();
        $session->set('taccode', $this->request->getpost('params')['veritac']);
    }
}