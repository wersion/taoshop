<?php

namespace backend\assets;

use yii\web\AssetBundle;
/**
 * Description of AppAsset
 *
 * @author tao
 */
class AppAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    
    public $css=[
        'css/font-awesome.css',
        'css/ace-fonts.css',
        'css/ace.css',
    ];
    
    public $js=[
        'js/jquery-ui.custom.js',
        'js/jquery.ui.touch-punch.js',
        'js/jquery.easypiechart.js',
        'js/jquery.sparkline.js',
        'js/flot/jquery.flot.js',
        'js/flot/jquery.flot.pie.js',
        'js/flot/jquery.flot.resize.js',
        'js/ace/elements.scroller.js',
        'js/ace/elements.colorpicker.js',
        'js/ace/elements.fileinput.js',
        'js/ace/elements.typeahead.js',
        'js/ace/elements.wysiwyg.js',
        'js/ace/elements.spinner.js',
        'js/ace/elements.treeview.js',
        'js/ace/elements.wizard.js',
        'js/ace/elements.aside.js',
        'js/ace/ace.js',
        'js/ace/ace.ajax-content.js',
        'js/ace/ace.touch-drag.js',
        'js/ace/ace.sidebar.js',
        'js/ace/ace.sidebar-scroll-1.js',
        'js/ace/ace.submenu-hover.js',
        'js/ace/ace.widget-box.js',
        'js/ace/ace.settings.js',
        'js/ace/ace.settings-rtl.js',
        'js/ace/ace.settings-skin.js',
        'js/ace/ace.widget-on-reload.js',
        'js/ace/ace.searchbox-autocomplete.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
    
}
