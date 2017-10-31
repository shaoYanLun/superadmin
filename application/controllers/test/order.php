<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $class = $this->router->fetch_class();
        
        $this->load->model("{$class}_model", "model", true);
    }
    function index(){
    	//权限判断
    	$currentFunc = $this->rabc->getCurrentFunc();
    	checkRightPage($currentFunc);
    	$arrWhere = $this->input->get(null, true);
    	$this->load->library('page');

		$page = new Page();
		$page->num = 5;
		$arrLimit = $page->getlimit();
		$arrWhere['ls'] = $arrLimit['ls'];
		$arrWhere['le'] = $arrLimit['le'];

		$arrRes = $this->model->getOrderlist($arrWhere);

		$all = $arrRes['num'];

		$data['list'] = $arrRes['list'];
		$data['page_view'] = $page->view(array(
			'all' => $all,
		));
		$this->load->myview('test/order', $data);
    }
}