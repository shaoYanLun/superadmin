<?php
class Createtemp extends MY_Controller {

	function __construct() {
		parent::__construct();
		//超级管理员 或 管理员有访问权限
		checkRightPage();
	}

	function index()
	{
		$this->load->myview("manage/autotemp");
	}
	function creater()
	{
		checkRightPage("superadmin");
		$arrGet = $this->input->get(null , true);

		if(empty($arrGet['tablename']))
		{
			ajax(-1 , array(), "缺少参数");
		}
		$tablename = $arrGet['tablename'];
		$field = empty($arrGet['field'])?"*":$arrGet['field'];

		$this->load->library("autotemp");

		$config['_tablename'] = $tablename;
		$config['_field'] = $field;
		$res = $this->autotemp->creater($config);

		if($res['code']!=1)
		{
			ajax(-1 , array() , $res['msg']);
		}

		$resinfo = $this->autotemp->resinfo();

		ajax(1 , $resinfo , "success");

	}

}