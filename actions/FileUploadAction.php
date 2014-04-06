<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\redactor\actions;

use yii\redactor\models\FileUploadModel;
use yii\helpers\Json;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class FileUploadAction extends  \yii\base\Action
{
    public $uploadDir = '@webroot/uploads';
    public $baseDir = '@webroot';
    public $baseUrl = '@web';

    public function run()
    {
        if (isset($_FILES)) {
            $model = new FileUploadModel(['uploadDir' => $this->uploadDir,'baseDir'=>$this->baseDir,'baseUrl'=>$this->baseUrl]);
            if ($model->upload()) {
                echo $model->toJson();
            } else {
                if ($model->firstErrors) {
                    echo Json::encode(['error' => $model->firstErrors[0]]);
                }
            }
        }
    }

}