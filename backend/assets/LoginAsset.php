<?php
namespace backend\assets;
use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    
    public $css = [
        'easyui/themes/bootstrap/easyui.css'
    ];
    
    public $js = [
        'easyui/jquery.easyui.min.js',
        'easyui/locale/easyui-lang-zh_CN.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}

?>