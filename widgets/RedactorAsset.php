<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\redactor\widgets;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class RedactorAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/yiiext/imperavi-redactor-widget/assets';
    public $depends = ['yii\web\JqueryAsset'];

    public function init()
    {

        if (YII_DEBUG)
            $this->js[] = 'redactor.js';
        else
            $this->js[] = 'redactor.min.js';
        $this->css[] = 'redactor.css';
    }

}