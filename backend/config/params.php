<?php
return [
    'adminEmail' => 'admin@example.com',
    //不需要登录的路由
    'notNeedLogin' => [
        'admin/login',
        'admin/captcha',
        'admin/post',
        
    ],
    'dataCache' => [
        'default' => ['cacheid'=>'cache'],
    ],
    'adminpassportkey'=>'7c9ea6d6afbd3d043b0cf50a4ea78239',
];
