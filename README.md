yii2-redactor
=============

The preferred way to install  this extension  is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist "karneds/yii2-redactor *"
```

or add

```json
"karneds/yii2-redactor": "*"
```

to the require section of your composer.json.


Usage:
--------------
#### in controller
```php
    public function actions(){
        return [
            'file' => [
                'class'=>'yii\redactor\actions\FileUploadAction',
                'uploadDir'=>'@webroot/uploads/blogs/files/'
            ],
            'image' => [
                'class'=>'yii\redactor\actions\ImageUploadAction',
                'uploadDir'=>'@webroot/uploads/blogs/images/'
            ],
            'imagejson' => [
                'class'=>'yii\redactor\actions\ImageGetJsonAction',
                'sourcePath'=>'@webroot/uploads/blogs/images/'
            ],
            'file' => [
                'class'=>'yii\redactor\actions\ClipboardUploadAction',
                'uploadDir'=>'@webroot/uploads/blogs/files/'
            ],
        ];
    }
```

#### in view
```php
    use \yii\helpers\Url;
    ...
    <?= $form->field($model,'text')->widget(yii\redactor\widgets\Redactor::className(),[
        'clientOptions'=>[
            'lang'=>'ru',
            'formattingTags'=>['p', 'blockquote', 'pre', 'h2', 'h3', 'h4'],
            'imageTabLink'=>false,
            'imageGetJson' => Url::toRoute(['pages'/imagejson']),
            'imageUpload' => Url::toRoute(['pages'/image']),
            'clipboardUploadUrl' =>Url::toRoute(['pages/clipboard']),
            'fileUpload' => Url::toRoute(['pages'/file']),
            'plugins' => ['clips', 'fullscreen']
        ]
    ])?>

```