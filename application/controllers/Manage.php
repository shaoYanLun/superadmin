<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$class= $this->router->fetch_class();

		$this->load->model("{$class}_model" , "model" , true);
	}

	function user()
	{
		$this->load->library('page');

		$page = new Page;
		$page->num = 50;

		$arrLimit = $page->getlimit();

		$arrWhere['ls'] = $arrLimit['ls'];
		$arrWhere['le'] = $arrLimit['le'];

		$arrRes = $this->model->getManageUserByWhere($arrWhere);

		$all = $arrRes['num'];

		$data['list'] = $arrRes['list'];
		$data['page_view'] = $page->view(array('all'=>$all));

		$this->load->myview('manage/user' , $data);
	}
}