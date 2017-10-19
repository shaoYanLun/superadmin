<?php

function c($item, $config = 'custom')
{
    $ci = & get_instance();
    $ci->config->load($config);
    return $ci->config->item($item);
}

/*
 * 接口返回数据
 */
function ajax($code, $data, $msg)
{
    $info = array();
    $info['data'] = $data;
    $info['msg'] = $msg;
    $info['code'] = $code;
    if (isset($_REQUEST['callback'])) {
        // jsonp
        header('Content-Type: application/javascript;charset=utf-8');
        exit($_REQUEST['callback'] . '(' . json_encode($info) . ')');
    } else {
        // json
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($info);
        exit();
    }
}

/*
 * 静态资源地址
 */
function static_url($url)
{
    return base_url() . "static/" . $url;
}

/**
 * 登录加密方式，可以使用更安全的password_hash
 *
 * @param unknown $pwd
 * @param unknown $salt
 * @return string
 */
function password($pwd, $salt)
{
    $pwd = sha1($pwd . $salt);
    return $pwd;
}

/**
 * 生成随机数
 * isup：是否含有大写
 */
function getRand($length = 10, $isup = false, $max = false)
{
    if (is_int($max) && $max > $length) {
        $length = mt_rand($length, $max);
    }
    $output = '';
    
    for ($i = 0; $i < $length; $i ++) {
        if ($isup) {
            $which = mt_rand(0, 2);
        } else {
            $which = mt_rand(0, 1);
        }
        
        if ($which === 0) {
            $output .= mt_rand(0, 9);
        } elseif ($which === 1) {
            $output .= chr(mt_rand(97, 122));
        } else {
            $output .= chr(mt_rand(65, 90));
        }
    }
    return $output;
}

function gconfig($ckey)
{
    $ci = & get_instance();
    $ci->load->model("Config_model");
    $config = Config_model::getPlatConfig();
    if (! isset($config[$ckey])) {
        return "";
    }
    return $config[$ckey];
}

/*
 * 错误提示页
 */
function errorpage($msg = "")
{
    echo $msg;
    exit();
}

/**
 * 
 * @param string $mark 标题描述
 * @param array() or string $ext 扩展信息说明。如记录返回结果或请求结果等
 * @return unknown
 */
function wlog($mark,$ext="") {
    $ci = & get_instance();
    $ci->load->model("Log_model");
    $newExt = $ext;
    if (is_array($ext)) {
        $newExt = json_encode($ext);
    }
    
    $uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:($ci->router->fetch_class() . "/" . $ci->router->fetch_method());
    $userInfo = checkLogin();
    $arr['username'] = $userInfo?$userInfo['username']:"未登录";
    $arr['uri'] = $uri;
    $arr['mark'] = $mark;
    $arr['mark_ext'] = $newExt;
    $arr['ip'] = get_client_ip();
    $ret = Log_model::insertLog($arr);
    return $ret;
}

/**
 * 获取ip
 * 首先获取remote_addr
 *
 * @return Ambigous <string, unknown>
 */
function get_client_ip()
{
    $ip = '0.0.0.0';
    $white_ip = array(); //
    if (! empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown") && substr($_SERVER['REMOTE_ADDR'], 0, 3) != "10." && $_SERVER['REMOTE_ADDR'] != '127.0.0.1' && ! in_array($_SERVER['REMOTE_ADDR'], $white_ip)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], "unknown")) {
        $arrIp = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arrIp);
        if (false !== $pos) {
            unset($arrIp[$pos]);
        }
        $ip = trim($arrIp[0]); // 默认获取第一个
    } elseif (! empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    return $ip;
}

function gor($msg = "", $go = "")
{
    $str = "<script>";
    empty($msg) ? "" : $str .= ("alert('" . $msg . "');");
    
    if (empty($go)) {
        $str .= "history.go(-1)</script>";
        echo $str;
        // $strlog= json_encode(array('str'=>$str));
        // inLog($strlog);
        exit();
    } else {
        $str .= "</script>";
        echo $str;
        // $strlog= json_encode(array('str'=>$str,'go'=>$go));
        // inLog($strlog);
        redirect($go);
    }
}