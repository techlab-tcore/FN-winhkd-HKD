<?php namespace App\Controllers;

use App\Controllers\BaseController;

class Lang_control extends BaseController
{
    // Translation
    public function translate()
    {
        $session = session();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        // $url = base_url();
        // return redirect()->to($url);
        return json_encode(['code'=>1]);
    }
}