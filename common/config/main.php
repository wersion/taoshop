<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath'=>'@common/cache',
        ],
        'urlManager' =>[
            'enablePrettyUrl'=>true,
            'showScriptName' => false,
        ],
    ],
];
