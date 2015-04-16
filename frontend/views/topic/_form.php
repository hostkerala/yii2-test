<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 250]) ?>
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>    
    <?= $form->field($model, 'topic_end')->widget(\yii\jui\DatePicker::classname(), [
     //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['class'=>'form-control']
    ]) ?> 
    <?php
    $dataCategory=ArrayHelper::map(\common\models\Categories::find()->asArray()->all(), 'id', 'name');
    echo $form->field($model, 'category_id')->dropDownList(
        $dataCategory       
    );
    ?>
    <?php
    echo '<label class="control-label">Tag Content</label>';
    echo Select2::widget([
        'model' => $model,
        'attribute' => 'skills',
        'name' => 'Skills',
        'data' => \common\models\Skill::getAllSkill(),
        'options' => [
            'placeholder' => 'desciplines',
            'class' => 'form-control',
            'multiple' => true
        ], 
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
