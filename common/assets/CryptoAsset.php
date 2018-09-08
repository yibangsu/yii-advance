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
class CryptoAsset extends AssetBundle
{
    public $sourcePath = '@vendor/crypto-js-3.1.9-1/assets';
    public $js = [
        'core.js',
        'sha256.js',
        'hmac.js',
        'hmac-sha256.js',
        'md5.js',
    ];
    public $depends = [
    ];
}
