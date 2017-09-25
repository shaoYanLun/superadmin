<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function login()
    {
        $this->load->library('session');
        if ($this->session->userdata('uname')) {
            redirect('/');
        }
        $uname = $this->input->post("uname", true);
        $pwd = $this->input->post("pwd", true);
        $code = $this->input->post("code", true);
        if ($uname == "" || $pwd == "") {
            ajax(- 1, null, "用户名或密码不能为空");
        }
        $lcode = gconfig("login_code");
        if ($lcode == 1) {
            $this->load->library("google2FA/Gfa");
            $res = Gfa::vali($arrlogin['key'], $code);
            if (! $res) {
                ajax('-3', '', '验证码错误');
            }
        }
        $this->load->model("User_model");
        // 此处可以用redis加入防刷机制
        $user = $this->User_model->getUserByName($uname);
        if (! $user || ! isset($user['salt']) || ! isset($user['password']) || password($pwd, $user['salt']) != $user['password']) {
            ajax(- 2, null, "用户名或者密码错误");
        }
        $this->User_model->wsession($user);
        ajax(1, null, "OK");
    }
}