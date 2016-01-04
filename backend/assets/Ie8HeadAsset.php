<?php
namespace backend\assets;
use yii\web\AssetBundle;
/**
 * Description of Ie8Asset
 *
 * @author tao
 */
class Ie8HeadAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $js = [
        'js/html5shiv.js',
        'js/respond.js'
    ];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
        'condition' => 'lte IE8'
    ];
    
}
