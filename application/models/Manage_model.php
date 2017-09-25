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

	function getManageUserByWhere( $arr = array() )
	{
		$sql = " select * from {$this->_strUser} where 1=1 ";
		$sqlNum = " select count(*) as num from {$this->_strUser} where 1=1 ";

		$arrWhere = array();
		$arrWhereNum = array();

		if(isset($arr['ls']))
		{
			$sql.=" limit ? , ?";
			$arrWhere[] = $arr['ls'];
			$arrWhere[] = $arr['le'];
		}

		$list = $this->_db->query($sql , $arrWhere)->result_array();
		$arrCount = $this->_db->query($sqlNum , $arrWhereNum)->row_array();

		return array(
			'list'=>$list,
			'num'=>$arrCount['num']
			);
	}

	function getMenu()
	{
		$this->_db->order_by('sort' , 'desc');
		$this->_db->where('type',1);
		return $this->_db->get($this->_strPlatMenu)->result_array();
	}
}