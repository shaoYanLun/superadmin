<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

if (! function_exists('checkRight')) {

    /**
     * 简要说明
     * checkRight 主要用于对页面或者功能部分判断是否有权限操作的的时候使用，如botton是否有权限显示与不显示
     *
     * @param unknown $right
     * @return boolean
     */
    function checkRight($right)
    {
        $ci = & get_instance();
        if ($ci->rabc->check($right)) {
            return true;
        }
        return false;
    }
}

if (! function_exists('checkRightPage')) {

    /**
     * 简要说明
     *
     * @param unknown $right
     */
    function checkRightPage($right)
    {
        header("Content-type:text/html;charset=utf-8");
        $ci = & get_instance();
        
        if (! checkRight($right)) {
            // 如果是jquery ajax访问的时候，直接返回json,如果不是ajax访问，调到没有权限的页面。注：如果前端不用jquery请求，用原生的需要加上此条： xmlhttp.setRequestHeader("X-Requested-With","XMLHttpRequest");
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
                ajax(- 999, null, "无权限访问");
            } else {
                echo "no access <a href='login' style='color:red;'><b>退出</b></a>";
                exit();
            }
        }
    }
}