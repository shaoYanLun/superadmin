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