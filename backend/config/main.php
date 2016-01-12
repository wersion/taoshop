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
                '*' =>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=> '@backend/messages',
                    'fileMap' => [
                        'config' => 'config.php',
                        'app'    => 'app.php',
                        'log'    => 'log.php',
                        'alipay'=> 'payment/alipay.php',
                        'bank'=>'payment/bank.php',
                        'paypal_ec'=>'payment/paypal_ec.php',
                        'kuaiqian'=>'payment/kuaiqian.php',
                        'paypal'=>'payment/paypal.php',
                        'cappay'=>'payment/cappay.php',
                        'ips'=>'payment/ips.php',
                        'wx_new_jspay'=>'payment/wx_new_jspay.php',
                        'wx_new_qrcode'=>'payment/wx_new_qrcode.php',
                        'cod'=>'payment/cod.php',
                        'shenzhou'=>'payment/shenzhou.php',
                        'tenpay'=>'payment/tenpay.php',
                        'post'=>'payment/post.php',
                        'balance'=>'payment/balance.php',
                        'chinabank'=>'payment/chinabank.php',
                        'upop'=>'payment/upop.php',
                        'tenpayc2c'=>'payment/tenpayc2c.php',
                    ]
                ]
            ],
        ],
    ],
    'params' => $params,
];
