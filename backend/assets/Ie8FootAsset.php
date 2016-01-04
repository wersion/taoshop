<?php
namespace backend\assets;

use yii\web\AssetBundle;
/**
 * Description of Ie8FootAsset
 *
 * @author tao
 */
class Ie8FootAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $js = [
        'js/excanvas.js',
    ];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
        'condition' => 'lte IE8'
    ];
    
     public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
