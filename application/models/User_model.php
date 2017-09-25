<?php

class User_model extends CI_Model
{

    private $_strUser = 'user';

    private $_strPlatConfig = 'plat_config';

    private $_strUserGroupRight = 'user_group_right';

    private $_strPlatMenu = 'plat_menu';

    private $_db = "";

    function __construct()
    {
        parent::__construct();
        if (empty($this->_db)) {
            $this->_db = $this->load->database('default', true);
        }
    }

    function wsession($user)
    {
        $level = $user['user_level'];
        $group = $user['user_group'];
        $baseRight = $user['user_right'];
        $jsonRight = $this->getUserRight($group, $baseRight, $level);
        
        $sess['level'] = $level;
        $sess['right'] = $jsonRight;
        $sess['username'] = $user['username'];
        
        $ci = &get_instance();
        $ci->load->library('session');
        $ci->session->set_userdata($sess);
        return $sess;
    }

    function getUserRight($group, $baseRight, $level)
    {
        // 管理员和超级管理员默认拥有所有的权限，无需判断用户组和right
        if ($level == 4 || $level == 8) {
            return "";
        }
        $right = array();
        if ($baseRight != "") {
            $right = explode(",", $right);
        }
        $sql = "select pm.action from {$this->_strUserGroupRight} ugr left join {$this->_strPlatMenu} pm on ugr.pmid=pm.id where ugr.ugid=?";
        $action = $this->_db->query($sql, array(
            $group
        ))->result_array();
        if ($action) {
            foreach ($action as $value) {
                $right[] = $value['action'];
            }
        }
        $jsonRight = json_encode($right);
        return $jsonRight;
    }

    function getUserByName($name)
    {
        $user = $this->_db->get_where($this->_strUser, array(
            "username" => $name
        ))->row_array();
        return $user;
    }

    function getPlatConfig()
    {
        $sql = "select * from {$this->_strPlatConfig}";
        $config = $this->_db->query($sql)->result_array();
        if (! $config) {
            return false;
        }
        $arrConfig = array();
        foreach ($config as $key => $value) {
            $arrConfig[$value['ckey']] = $value['cvalue'];
        }
        return $arrConfig;
    }
}