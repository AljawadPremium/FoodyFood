<?php

namespace App\Controllers\AdminControllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\DbModel;
use CodeIgniter\Cookie\Cookie;

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
class AdminController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $mViewData = array();
    protected $mBodyClass = '';
    protected $mLanguage = 'en';
    protected $session ='';
    protected $admin_id ='';
    protected $db_model;
    protected $admin_data = array();
    protected $sidd_header_path = ROOTPATH.'app/Views/admin/side_header.php';
    protected $footer_copyright ='Copyright 2022 © Technology All Rights Reserved.';

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {    
        // echo 1234; die;    
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->db_model = new DbModel();  
        
        $this->admin_id = $this->session->get('admin_id');
        $this->admin_data();     
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();        
    }

    public function Urenderadmin($view_file, $layout = 'default', $page_name ='')
    {
        // echo $page_name; die;
        $this->mViewData['body_class'] = $this->mBodyClass;

        $this->mViewData['page_title'] = $page_name;

        $router = service('router'); 

        $this->mViewData['ctrler']  = $router->controllerName(); 

        $this->mViewData['module']  = $router->methodName();         
        
        $this->mViewData['base_url'] = base_url();
        $this->mViewData['language'] = $this->mLanguage;
        $this->mViewData['sidd_header_path'] = $this->sidd_header_path;
        $this->mViewData['footer_copyright'] = $this->footer_copyright;
        $this->mViewData['admin_data'] = $this->admin_data;
        $this->mViewData['currency'] = 'SAR';
        
        // echo "<pre>";
        // print_r( $this->admin_data);
        // die;

        if ($layout == 'default') 
        {
            echo view('_layouts/admin/unavbar', $this->mViewData);
            echo view('admin/'.$view_file, $this->mViewData);
            echo view('_layouts/admin/footer', $this->mViewData);
        }
        if ($layout == 'empty') 
        {
            echo view('admin/'.$view_file, $this->mViewData);
        }
    }

    private function admin_data()
    {
        $this->admin_data = $this->db_model->my_where('admin_users','*',array("id"=>$this->admin_id));
    }

    public function pagination($page_arr)
    {
        $pager = \Config\Services::pager(); 
        $pagination_link = '';
        if ($page_arr['rowperpage'] <= $page_arr['data_count']) 
        {
            $pagination_link = $pager->makeLinks($page_arr['active_page'], $page_arr['rowperpage'], $page_arr['data_count']);
        }
        return $pagination_link;
    }
    
    public function is_logged_in()
    {
        $this->session = \Config\Services::session();
        $admin_id = $this->session->get('admin_id');

        if(empty($admin_id)) {
            $url = base_url('admin/login');
            echo 'You don\'t have permission to access this page. Please <a href="'.$url.'">Login</a>';    
            die();
        }
    }

    public function seller_blocked()
    {
        $this->session = \Config\Services::session();
        $admin_id = $this->session->get('admin_id');

        $this->db_model = new DbModel();
        $s_data = $this->db_model->my_where('admin_users','id',array("id" => $admin_id,"type" => "seller"));
        
        // echo "<pre>"
        if(empty($admin_id)) {
            $url = base_url('admin/login');
            echo 'You don\'t have permission to access this page. Please <a href="'.$url.'">Login</a>';    
            die();
        }
        if(!empty($s_data)) {
            $url = base_url('admin');
            echo 'You don\'t have permission to access this page. <a href="'.$url.'">back to dashboard </a>';    
            die();
        }
    }
}
