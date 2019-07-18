<?php
/**
 * @link         http://www.rulaiyun.cn/
 * @author       wang <wangyaxu7019@dingtalk.com>
 * @copyright    Copyright &copy; rulaiyun.cn,2018 - 2019
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * 资源管理
 * Class AppAsset
 *
 * @package backend\assets
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //        'css/site.css',
        //        'css/style.min.css'
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
