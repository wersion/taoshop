<?php
namespace backend\assets;
use yii\web\AssetBundle;

class LoginAsset extends AssetBundle{
     public $basePath = '@webroot';
    public $baseUrl  = '@web';
    
    public $css=[
        'css/font-awesome.css',
        'css/ace-fonts.css',
        'css/ace.css',
        'css/ace-rtl.css'
    ];
    
    public $js=[
        
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
