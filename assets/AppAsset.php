<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        // reset all css
        'css/normalize.css',
        // third party @CSS styles
        'css/bootstrap.min.css',
        'css/bootstrap-responsive.min.css',
        'css/font-awesome.min.css',
        'css/jquery-ui.css',
        // assets@styles
        'css/app_master.css',
        'css/app_helper.css',
        'css/app_responsive.css',
        'css/app_override.css',
    ];
    public $js = [
    	'js/vendor/modernizr.min.js',
    	'js/vendor/bootstrap.min.js',
    	//'js/vendor/jquery-1.11.1.min.js',
    	'js/vendor/DD_belatedPNG_0.0.8a.js',
    	'js/vendor/jquery-ui.min.js',
		'js/vendor/native.js',
    	'js/plugins.js',
    	'js/app_master.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
