<?php

class Manage_model extends CI_Model
{

    private $_strUser = 'user';

    private $_strPlatMenu = 'plat_menu';

    private $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
    }

    // 用户查询
    function getManageUserByWhere($arr = array())
    {
        $p = "id,username,nick_name,gcode,user_group,user_level,user_right,status,salt,ctime,mtime";
        $sql = " select {$p} from {$this->_strUser} where 1=1 ";
        $sqlNum = " select count(*) as num from {$this->_strUser} where 1=1 ";
        
        $arrWhere = array();
        $arrWhereNum = array();
        
        if (isset($arr['ls'])) {
            $sql .= " limit ? , ?";
            $arrWhere[] = $arr['ls'];
            $arrWhere[] = $arr['le'];
        }
        
        $list = $this->_db->query($sql, $arrWhere)->result_array();
        $arrCount = $this->_db->query($sqlNum, $arrWhereNum)->row_array();
        
        return array(
            'list' => $list,
            'num' => $arrCount['num']
        );
    }

    function getMenuKv()
    {
        $menu = $this->_db->get($this->_strPlatMenu)->result_array();
        if (! $menu) {
            return false;
        }
        $arr = array();
        foreach ($menu as $value) {
            if ($value['action']) {
                $arr[$value['action']] = $value['mname'];
            }
        }
        return $arr;
    }

    // 获取目录
    function getMenu($arrWhere = array())
    {
        $this->_db->order_by('sort', 'desc');
        $arrWhere = $arrWhere;
        $arrWhere['type'] = 1;
        $arrWhere['status'] = 1;
        $this->_db->where($arrWhere);
        return $this->_db->get($this->_strPlatMenu)->result_array();
    }

    // 获取目录
    function getMenuByWhere($arrWhere)
    {
        return $this->_db->get_where($this->_strPlatMenu, $arrWhere)->result_array();
    }

    // 获取权限
    function getAction()
    {
        $this->_db->order_by('sort', 'desc');
        $this->_db->where('type', 2);
        $this->_db->where('status', 1);
        return $this->_db->get($this->_strPlatMenu)->result_array();
    }

	//获取目录
	function getMenu($arrWhere = array())
	{
		$this->_db->order_by('sort' , 'desc');
		$arrWhere = $arrWhere;
		$arrWhere['type'] = 1;
		$arrWhere['status'] = 1;
		$this->_db->where($arrWhere);
		return $this->_db->get($this->_strPlatMenu)->result_array();
	}
	//获取目录
	function getMenuByWhere($arrWhere)
	{
		return $this->_db->get_where($this->_strPlatMenu ,$arrWhere )->result_array();
	}
	//获取权限
	function getAction()
	{
		$this->_db->order_by('sort' , 'desc');
		$this->_db->where('type',2);
		$this->_db->where('status',1);
		return $this->_db->get($this->_strPlatMenu)->result_array();
	}
	//插入目录权限
	function insertMenu($arrInsert)
	{
		$arrInsert['ctime'] = date("Y-m-d H:i:s" ,time());
		$arrInsert['mtime'] = date("Y-m-d H:i:s" ,time());
		$this->_db->insert($this->_strPlatMenu , $arrInsert);
		return $this->_db->insert_id();
	}
	//修改目录
	function EditMenu($arrEdit , $arrWhere)
	{
		$arrEdit['mtime'] = date("Y-m-d H:i:s");
		return $this->_db->update($this->_strPlatMenu , $arrEdit , $arrWhere);
	}
	//删除目录
	function deleteMenuByWhere($arr)
	{
		return $this->_db->delete($this->_strPlatMenu ,$arr);
	}
}