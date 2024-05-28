<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if user not logged in
        if( !session()->get('logged_in') ){
            // then redirct to login page
            // return redirect()->to(base_url());

            // echo json_encode(['code'=>-1, 'message'=>'Please log in account']);
            $session = session();
            clearstatcache();
            return redirect()->to(base_url());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
        // return redirect()->to(base_url());
    }
}