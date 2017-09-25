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
        exit(json_encode($info));
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