<?php
/*
 * 数据库 status 状态 描述
 */
$config['table_desc'] = array(
    'user' => array(
        'status' => array(
            '2' => '正常',
            '3' => '锁定'
        ),
        'user_level' => array(
            '1' => '普通用户',
            '2' => '普通管理员',
            '4' => '管理员',
            '8' => '超级管理员'
        )
    
    ),
    'plat_menu' => array(
        'status' => array(
            '1' => '显示',
            '2' => '不显示'
        )
    )
);