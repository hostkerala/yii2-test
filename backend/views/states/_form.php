<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\States */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="states-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $dataCountry=ArrayHelper::map(\common\models\Countries::find()->asArray()->all(), 'id', 'country_name_en');
    echo $form->field($model, 'country_id')->dropDownList(
        $dataCountry       
    );
    ?>
    
    <?= $form->field($model, 'state_code')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'state_name_en')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'state_name_ru')->textInput(['maxlength' => 64]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
