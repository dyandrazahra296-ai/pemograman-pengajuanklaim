<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class HrdFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    if (!session()->get('logged_in') || session()->get('role') != 'hrd') {
        return redirect()->to('/login');
    }
}


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
