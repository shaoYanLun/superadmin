<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        checkRightPage();
        $class = $this->router->fetch_class();
        
        $this->load->model("{$class}_model", "model", true);
    }

    function index()
    {
        wlog("访问日志");
        $this->load->library('page');
        
        $page = new Page();
        $page->num = 50;
        
        $arrLimit = $page->getlimit();
        
        $arrWhere['ls'] = $arrLimit['ls'];
        $arrWhere['le'] = $arrLimit['le'];
        
        $arrRes = Log_model::getLog($arrWhere);
        
        $all = $arrRes['num'];
        
        $data['list'] = $arrRes['list'];
        $data['page_view'] = $page->view(array(
            'all' => $all
        ));
        
        $this->load->myview('log/index', $data);
    }
}