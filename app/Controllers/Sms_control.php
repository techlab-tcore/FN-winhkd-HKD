<?php

namespace App\Controllers;

class Sms_control extends BaseController
{
    public function sendWhatsapp()
    {
        $length = strlen($this->request->getpost('params')['contact']);
        $pass = $this->request->getpost('params')['veritac'];
        //$message = '['.$_ENV['company'].']---'.$pass.'---';
        $message = '[w]---'.$pass.'---';

        if ($this->request->getpost('params')['mobilecode'] == 'HKD') {
            $regionCode = 852;
        } elseif ($this->request->getpost('params')['mobilecode'] == 'MYR') {
            $regionCode = 6;
        } else {
            $regionCode = 66;
        }

        // Checking Mobile Number
        // $firstChar = substr($this->request->getpost('params')['contact'], 0, $_ENV['numMobileCode']);
        // if( $firstChar!=$_ENV['mobileCode'] ):
        //     // $str = ltrim($this->request->getPost('params')['mobile'], '6');
        //     echo json_encode([
        //         'code' => -1,
        //         'message' => lang('Validation.mobile',[8,10])
        //     ]);
        // else:
            // Valid Mobile Number
            if( $length>=8 ):
                $payload = [
                    //'to' => $_ENV['mobileCode'].$this->request->getpost('params')['contact'],
                    'to' => $regionCode.$this->request->getpost('params')['contact'],
                    //'message' => $this->request->getpost('params')['message']
                    'message' => $message
                ];
                $res = $this->sms_model->insertWhatsapp($payload);
                // echo json_encode($res);

                if( $res['message_status']=='Success' ):
                    $session = session();
                    $session->set('taccode', $this->request->getpost('params')['veritac']);
                endif;

                echo json_encode([
                    'code' => 1,
                    'message' => $res['message_status']
                ]);
            else:
                echo json_encode([
                    'code' => -1,
                    'message' => lang('Validation.mobile',[8,12]),
                ]);
            endif;
        // endif;
    }

    public function sendSmsWithTAC()
    {
        $length = strlen($this->request->getpost('params')['contact']);

        $length_of_string = 6;
        $str_result = '0123456789';
        $veritac = substr(str_shuffle($str_result), 0, $length_of_string);

        $msg = '[W8]--'.$veritac.'--';
        $msg .= 'Code to be used once for login security verification. Do not share Code with others. Disregard this SMS if you did not intend to log in.';

        // Checking Mobile Number
        //$firstChar = substr($this->request->getpost('params')['contact'], 0, $_ENV['numMobileCode']);
        //if( $firstChar==$_ENV['mobileCode'] ):
        //    // $str = ltrim($this->request->getPost('params')['mobile'], '6');
        //    echo json_encode([
        //        'code' => -1,
        //        'message' => lang('Validation.mobile',[8,9])
        //    ]);
        //else:
            // Valid Mobile Number
            //if( $length==8 || $length==9 ):
                $payload = [
                    'type' => "2",
                    'regioncode' => $this->request->getpost('params')['mobilecode'],
                    'contactno' => $this->request->getpost('params')['contact'],
                    'text' => $msg
                    //'text' => $this->request->getpost('params')['message']
                ];
                $res = $this->sms_model->insertSms($payload);
                //echo json_encode($res);

                if( $res['code']==1 ):
                    $session = session();
                    //$session->set('taccode', $this->request->getpost('params')['veritac']);
                    $session->set('taccode', $veritac);
                endif;
                echo json_encode($res);
            //else:
            //    echo json_encode([
            //        'code' => -1,
            //        'message' => lang('Validation.mobile',[8,9]),
            //    ]);
            //endif;
        //endif;
    }

    public function sendSMS()
    {
        $length = strlen($this->request->getpost('params')['contact']);

        // Checking Mobile Number
        $firstChar = substr($this->request->getpost('params')['contact'], 0, $_ENV['numMobileCode']);
        if( $firstChar==$_ENV['mobileCode'] ):
            // $str = ltrim($this->request->getPost('params')['mobile'], '6');
            echo json_encode([
                'code' => -1,
                'message' => lang('Validation.mobile',[8,9])
            ]);
        else:
            // Valid Mobile Number
            if( $length==8 || $length==9 ):
                $payload = [
                    'type' => "1",
                    'regioncode' => $_ENV['currencyCode'],
                    'contactno' => $this->request->getpost('params')['contact'],
                    'text' => $this->request->getpost('params')['message']
                ];
                $res = $this->sms_model->insertSms($payload);
                echo json_encode($res);

                // if( $res['code']==1 ):
                //     $session = session();
                //     $session->set('taccode', $this->request->getpost('params')['veritac']);
                // endif;
            else:
                echo json_encode([
                    'code' => -1,
                    'message' => lang('Validation.mobile',[8,9]),
                ]);
            endif;
        endif;
    }
}