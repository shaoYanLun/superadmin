<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function user()
	{
		$this->load->myview('manage/user');
	}
}