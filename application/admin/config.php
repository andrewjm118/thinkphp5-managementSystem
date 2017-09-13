<?php
//配置文件
return [
    'AUTH_CONFIG'=>array(
        'AUTH_ON'=>true,//认证开关
        'AUTH_TYPE'=>1,// 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP'=>'cuoti_auth_group',//用户组数据表名
        'AUTH_GROUP_ACCESS'=>'cuoti_auth_group_access',//用户组明细表
        'AUTH_RULE'=>'cuoti_auth_rule',//权限规则表
        'AUTH_USER'=>'cuoti_user'//用户信息表
   )
];