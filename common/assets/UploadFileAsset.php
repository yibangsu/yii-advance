<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UploadFileAsset extends AssetBundle
{
    public $sourcePath = '@vendor/hip/uploadFile/assets/js';
    public $js = [
        'hip.upload.js',
    ];
    public $depends = [
         
    ];
}
