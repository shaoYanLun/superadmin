<?php

class Rabc
{

    public function check($a)
    {
        $ci = & get_instance();
        $ci->load->library('session');
        $level = $ci->session->userdata('level');
        $right = $ci->session->userdata('right');
        if ($level == 8) {
            return true;
        }
        if ($level != 8 && $a == "superadmin") {
            return false;
        }
        if ($level == 4) {
            return true;
        }
        
        $arrRight = json_decode($right, true);
        if (! in_array($a, $arrRight)) {
            return false;
        }
        return true;
    }

    /*
     * 获取左侧导航目录
     * return
     * arrmenu
     * current
     */
    function getMenu()
    {
        $CI = &get_instance();
        
        $CI->load->model('Manage_model');
        
        $arrMenuList = $CI->Manage_model->getMenu();
        
        $arrRes = array();
        $arrCurent = array(
            'mname' => '',
            'desription' => '',
            'url' => '',
            'parent' => ''
        );
        
        $atfunc = $CI->router->fetch_class() . "/" . $CI->router->fetch_method();
        
        if (! empty($arrMenuList)) {
            $arrLinkMenu = array();
            foreach ($arrMenuList as $key => $arrMenu) {
                
                if ($arrMenu['url'] == $atfunc) {
                    $arrCurent = array(
                        'mname' => $arrMenu['mname'],
                        'desription' => $arrMenu['desription'],
                        'url' => $arrMenu['url'],
                        'parent' => $arrMenu['parent']
                    );
                }
                
                ! isset($arrLinkMenu[$arrMenu['id']]) ? $arrLinkMenu[$arrMenu['id']] = array() : "";
                
                if (empty($arrMenu['parent'])) {
                    $arrMenu['_list'] = &$arrLinkMenu[$arrMenu['id']];
                    $arrRes[] = $arrMenu;
                } else {
                    $arrLinkMenu[$arrMenu['parent']][] = $arrMenu;
                }
            }
        }
        
        return array(
            "arrmenu" => $arrRes,
            "current" => $arrCurent
        );
    }
}