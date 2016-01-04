<?php
namespace backend\assets;
use yii\web\AssetBundle;
/**
 * Description of Ie9Asset
 *
 * @author tao
 */
class Ie9HeadAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ace-part2.css',
        'css/ace-ie.css'
    ];
    public $cssOptions = [
        'condition' => 'lte IE9'
    ];
    public $js = [
        'js/ace-extra.js',
    ];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
