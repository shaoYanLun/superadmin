<?php
class Manage_model extends CI_Model
{
	private $_strUser = 'user';
	private $_strPlatMenu = 'plat_menu';
	private $_db = "";
	function __construct()
	{
		parent::__construct();
		if(empty($this->_db))
		{
			$this->_db = $this->load->database('default' , true);
		}
	}

	function getManageUserByWhere( $arrWhere = array() )
	{
		return $this->_db->get_where($this->_strUser , $arrWhere)->result_array();
	}

	function getMenu()
	{
		$this->_db->order_by('sort' , 'desc');
		$this->_db->where('type',1);
		return $this->_db->get($this->_strPlatMenu)->result_array();
	}
}