<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filePath')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'itemId')->textInput() ?>

    <?= $form->field($model, 'isMain')->textInput() ?>

    <?= $form->field($model, 'modelName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urlAlias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
