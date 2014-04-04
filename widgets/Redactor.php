<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\redactor\widgets;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class Redactor extends InputWidget
{

    public $options = [];
    public $clientOptions = [];
    public $clientDefaultOptions = [
        'imageGetJson' => '/redactor/upload/imagejson',
        'imageUpload' => '/redactor/upload/image',
        'clipboardUploadUrl' => '/redactor/upload/clipboard',
        'fileUpload' => '/redactor/upload/file'
    ];

    public function init()
    {
        if ($this->hasModel()) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        } else {
            $this->options['id'] = $this->getId();
        }
        $this->clientOptions = ArrayHelper::merge($this->clientDefaultOptions,$this->clientOptions);

        if ($this->clientOptions['imageUpload']) {
            $this->clientOptions['imageUploadErrorCallback'] = new JsExpression("function(json){alert(json.error);}");
        }
        if ($this->clientOptions['fileUpload']) {
            $this->clientOptions['fileUploadErrorCallback'] = new JsExpression("function(json){alert(json.error);}");
        }

        $request = Yii::$app->getRequest();
        $this->clientOptions['uploadFields'] = [$request->csrfParam=>$request->getCsrfToken()];

        $this->registerBundles();
        $this->registerScript();
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
    }

    public function registerBundles()
    {
        RedactorAsset::register($this->getView());
        if(isset($this->clientOptions['lang'])){
            RedactorRegionalAsset::register($this->getView())->language = $this->clientOptions['lang'];
        }
        if (isset($this->clientOptions['plugins']) && count($this->clientOptions['plugins'])) {
            foreach ($this->clientOptions['plugins'] as $plugin) {
                $assetBundle = 'yii\redactor\RedactorPlugin' . ucfirst($plugin) . 'Asset';
                if (class_exists($assetBundle)) {
                    $assetBundle::register($this->getView());
                }
            }
        }
    }

    public function registerScript()
    {
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').redactor({$clientOptions});");
    }

}