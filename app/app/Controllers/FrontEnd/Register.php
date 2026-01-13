<?php

namespace App\Controllers\FrontEnd;

class Register extends FrontController
{
    public function index()
    {
        $this->Urender('register','default', $page_name = 'Register');
    }
}
