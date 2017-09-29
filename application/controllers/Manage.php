<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $class = $this->router->fetch_class();
        
        $this->load->model("{$class}_model", "model", true);
    }

    /*
     * 用户管理相关
     * 用户列表
     */
    function user()
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

    /*
     * 目录管理
     *
     */
    function navigation()
    {
        /*
         * 获取权限列表
         */
        $arrAction = $this->model->getAction();
        
        $actionlist = array();
        
        if (! empty($arrAction)) {
            foreach ($arrAction as $value) {
                $actionlist[$value['parent']][] = $value;
            }
        }
        $data['actionlist'] = $actionlist;
        $this->load->myview('manage/navigation', $data);
    }

    // 添加一级目录
    function addFirstMenu()
    {
        $arrGet = $this->input->get(null, true);
        if (empty($arrGet['mname'])) {
            ajax(- 1, array(), '必须填写目录名');
        }
        if (empty($arrGet['icon'])) {
            ajax(- 1, array(), '必须填写图标');
        }
        if (empty($arrGet['radio'])) {
            ajax(- 1, array(), '必须选择状态');
        }
        
        if (! empty($arrGet['mname'])) {
            $arrWhere = array(
                'mname' => $arrGet['mname']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '目录名已存在，请重新定义');
            }
        }
        if (! empty($arrGet['url'])) {
            $arrWhere = array(
                'url' => $arrGet['url']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '访问地址已存在，请重新定义');
            }
        }
        if (! empty($arrGet['action'])) {
            $arrWhere = array(
                'action' => $arrGet['action']
            );
            
            $arrRes = $this->model->getMenuByWhere($arrWhere);
            if (! empty($arrRes[0])) {
                ajax(- 1, array(), '权限别名已存在，请重新定义');
            }
        }
        $arrInsert = array(
            "mname" => $arrGet['mname'],
            "url" => empty($arrGet['url']) ? "" : $arrGet['url'],
            "icon" => $arrGet['icon'],
            "parent" => 0,
            "type" => 1,
            "status" => $arrGet['radio']
        );
        
        $bool = $this->model->insertMenu($arrInsert);
        if (! $bool) {
            ajax(- 1, array(), '数据库错误');
        }
        
        ajax(1, array(), 'success');
    }

    // 删除目录
    function deleteMenu()
    {
        $id = $this->input->get('id', true);
        $arrWhere = array(
            'id' => $id,
            'type' => 1
        );
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (empty($arrRes[0])) {
            ajax(- 1, array(), "目录不存在");
        }
        $arrWhere = array(
            'parent' => $id,
            'type' => 1
        );
        $arrRes = $this->model->getMenuByWhere($arrWhere);
        if (! empty($arrRes)) {
            ajax(- 1, array(), "请先删除子目录");
        }
        
        $arrWhere = array(
            'id' => $id,
            'type' => 1
        );
        $bool = $this->model->deleteMenuByWhere($arrWhere);
        if (! $bool) {
            ajax(- 1, array(), "删除失败");
        }
        ajax(1, array(), 'success');
    }
}