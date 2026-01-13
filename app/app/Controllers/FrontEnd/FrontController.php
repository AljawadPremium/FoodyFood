<?php

namespace App\Controllers\FrontEnd;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\DbModel;
use App\Libraries\CommonFun;

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

class FrontController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    
    protected $request;
    protected $mViewData = array();
    protected $lang_data = array();
    protected $mBodyClass = '';
    protected $mLanguage;
    protected $comf;
    protected $currency = '';
    protected $user_id ='';
    protected $session ='';
    protected $db_model;

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
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();  

        $this->user_id = $this->session->get('uid');
        $this->currency = "SAR";
        $this->db_model = new DbModel();
        $this->comf = new CommonFun();
        $lang = $this->comf->get_lang();
        $this->request->setLocale($lang);
        $this->mLanguage = $this->request->getLocale();
        $this->mBodyClass = "body_".$this->mLanguage;

        $this->lang_data = $this->language_arr($request->config->supportedLocales, $this->mLanguage);

        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
    }

    public function Urender($view_file, $layout = 'default', $page_name ='')
    {
        $this->mViewData['body_class'] = $this->mBodyClass;
        $this->mViewData['lang_data'] = $this->lang_data;

        $this->mViewData['page_name'] = $page_name;

        $router = service('router'); 

        $this->mViewData['ctrler']  = $router->controllerName();
        $this->mViewData['module']  = $router->methodName();
        $language = $this->mLanguage;
        $this->mViewData['language'] = $this->mLanguage;
        $this->mViewData['currency'] = $this->currency;

        $user_data = array();
        if(!empty($this->user_id))
        {
            $user_data = $this->db_model->my_where('admin_users','*',array("id"=>$this->user_id,"type"=>"user"));
            if(!empty($user_data))
            {
                if($user_data[0]['logo']){
                    $user_data[0]['logo'] = base_url().'/public/logo/'.$user_data[0]['logo'];
                }
            }
        }

        
        $this->mViewData['user_data'] = $user_data;

        $cat_listing = $this->db_model->my_where('category','id,display_name,display_name_ar',array("parent"=>"0"));
        if ($language == 'ar') 
        {
            if ($cat_listing) {
                foreach ($cat_listing as $key => $value) {
                    $display_name = $value['display_name_ar'];
                    $cat_listing[$key]['display_name'] = $display_name;

                }
            }
        }
        $this->mViewData['cat_listing'] = $cat_listing;

        // echo "<prE>";
        // print_r($language);
        // die;

        $footer_cat_listing = $this->db_model->get_data_array("SELECT id,display_name,display_name_ar FROM category WHERE  `parent` = '0' ORDER BY id DESC LIMIT 4 ");
        if ($language == 'ar') 
        {
            if ($footer_cat_listing) {
                foreach ($footer_cat_listing as $key => $value) {
                    $display_name = $value['display_name_ar'];
                    $footer_cat_listing[$key]['display_name'] = $display_name;
                }
            }
        }

        $this->mViewData['footer_cat_listing'] = $footer_cat_listing;

        // echo "<pre>";
        // print_r($cat_listing);
        // die;


        if($layout=='default')
        {
            echo view('_layouts/frontend/unavbar', $this->mViewData);
            echo view('frontend/'.$view_file, $this->mViewData);
            echo view('_layouts/frontend/footer', $this->mViewData);
        }else{
            echo view($view_file, $this->mViewData);
        }
    }

    public function language_arr($language_arr,$language)
    {
        $lang_data = array();
        if(!empty($language_arr))
        {
            foreach ($language_arr as $key => $val) 
            {
               $is_active="";
               if($val==$language)
               {
                  $is_active="active";
               } 
               $lang_data[$key]['lang_nm'] =$val;  
               $lang_data[$key]['is_active'] =$is_active;  
               $lang_data[$key]['flag_url'] =$this->comf->imagePath("",$val.'.png','frontend');  
            }
        }
        sort($lang_data);
        return $lang_data;
    } 

    public function pagination($page_arr)
    {
       $pager = \Config\Services::pager(); 
       $pagination_link = $pager->makeLinks($page_arr['active_page'], $page_arr['rowperpage'], $page_arr['data_count']);
       return $pagination_link;
    }
}
