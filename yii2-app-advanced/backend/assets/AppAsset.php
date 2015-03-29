<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $publishOptions = ['forceCopy' => true];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'jquery-ui/jquery-ui.min.css',
        'css/site.css',
    ];
    public $js = [
        'jquery-ui/jquery-ui.min.js',
        '//maps.google.com/maps/api/js?sensor=false',
        'js/map-field.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
