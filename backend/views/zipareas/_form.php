<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Zipareas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zipareas-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
    
    $dataCategory=ArrayHelper::map(\common\models\Countries::find()->asArray()->all(), 'id', 'country_name_en');
    echo $form->field($model, 'country_id')->dropDownList($dataCategory, 
             ['prompt'=>'-Choose a Country-',
              'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('states/lists?id=').'"+$(this).val(), function( data ) {
                  $( "select#zipareas-state" ).html( data );
                });
            ']); 
 
    $dataPost=ArrayHelper::map(\common\models\States::find()->asArray()->all(), 'id', 'state_name_en');
    echo $form->field($model, 'state')
        ->dropDownList(
            $dataPost,           
            ['maxlength' => 2,'prompt'=>'-Choose a state-']
        );
    ?>
    <?= $form->field($model, 'zip')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'old_lng')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'old_lat')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
