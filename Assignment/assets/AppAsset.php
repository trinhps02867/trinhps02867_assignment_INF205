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
        'public/css/main.css',
        'public/css/creative.css',
        'public/css/creative.min.css',
        'public/css/magnific-popup.css',
    ];
    public $js = [
        'public/js/jquery-3.0.0.min.js',
        'public/js/creative.js',
        'public/js/creative.min.js',
        'public/js/jquery.easing.min.js',
        'public/js/jquery.fittext.js',
        'public/js/jquery.js',
        'public/js/jquery.magnific-popup.js',
        'public/js/jquery.magnific-popup.min.js',
        'public/js/scrollreveal.js',
        'public/js/scrollreveal.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
