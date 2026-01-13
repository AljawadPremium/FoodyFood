<?php
namespace App\Controllers\AdminControllers;
use App\Libraries\CommonFun;

class Setting extends AdminController
{       
    protected $comf;
    function __construct()
    {                
       $this->comf = new CommonFun();
       $this->is_logged_in();
    }
}