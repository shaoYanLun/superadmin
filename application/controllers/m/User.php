<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $class = $this->router->fetch_class();
        
        $this->load->model("{$class}_model", "model", true);
    }

    function index()
    {
        $this->load->library('page');
        
        $page = new Page();
        $page->num = 50;
        
        $arrLimit = $page->getlimit();
        
        $arrWhere['ls'] = $arrLimit['ls'];
        $arrWhere['le'] = $arrLimit['le'];
        
        $arrRes = $this->model->getManageUserByWhere($arrWhere);
        
        $all = $arrRes['num'];
        
        $data['list'] = $arrRes['list'];
        $data['page_view'] = $page->view(array(
            'all' => $all
        ));
        
        $right = $this->model->getMenuKv();
        $data['right'] = $right;
        
        $this->load->myview('manage/user', $data);
    }

    // 添加用户
    function ajaxAddUser()
    {
        checkRightPage();
        $uname = $this->input->post("uname", true);
        $pwd = $this->input->post("pwd", true);
        $nick_name = $this->input->post("nick_name", true);
        if ($uname == "" || $pwd == "" || $nick_name) {
            ajax(- 1, null, "用户名或者密码或者昵称不能为空");
        }
        $arr['uname'] = $uname;
        $arr['pwd'] = $pwd;
        $arr['nick_name'] = $nick_name;
        
        $user = $this->model->addUser($arr);
        $data['uname'] = $uname;
        ajax($user['code'], $data, $user['msg']);
    }

    // 管理员修改密码
    function ajaxAdminCPwd()
    {
        checkRightPage();
        $uname = $this->input->post("uname", true);
        $pwd = $this->input->post("pwd", true);
        if ($uname == "" || $pwd == "") {
            ajax(- 1, null, "参数错误");
        }
        $user = $this->model->getUserByName($uname);
        if (! $user) {
            ajax(- 2, null, "获取当前用户失败");
        }
        $data['password'] = password($pwd, $salt);
        $where['username'] = $uname;
        $isS = $this->model->updateUser($data, $where);
        if (! $isS) {
            ajax(- 3, null, "修改密码失败");
        }
        ajax(1, null, "更新成功");
    }

    // 用户自己修改密码
    function ajaxChangePwd()
    {
        $user = checkLogin();
        if (! $user) {
            ajax(- 1, null, "请先登录");
        }
        $uname = $user['username'];
        $opwd = $this->input->post("opwd", true);
        $npwd = $this->input->post("npwd", true);
        if ($opwd == "" || $npwd == "") {
            ajax(- 1, null, "新密码或者老密码不能为空");
        }
        $user = $this->model->getUserByName($uname);
        if (! $user) {
            ajax(- 2, null, "获取当前用户失败");
        }
        $salt = $user['salt'];
        if ($user['password'] != password($opwd, $salt)) {
            ajax(- 3, null, "老密码不正确");
        }
        $data['password'] = password($npwd, $salt);
        $where['username'] = $uname;
        $isS = $this->model->updateUser($data, $where);
        if (! $isS) {
            ajax(- 3, null, "修改密码失败");
        }
        ajax(1, null, "更新成功");
    }
}