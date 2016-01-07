<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'TaoShop后台管理系统',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'=>'default/index',
    'language'=>'zh-CN',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
         'user' => [
            'class'=>'common\component\WebUserD',
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'idParam'=>'__admin',
            'userType'=> 'admin',
            'loginUrl' => ['admin/login'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n'=>[
            'translations'=>[
                'config'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@backend/messages'
                ]
            ],
        ],
    ],
    'params' => $params,
];
