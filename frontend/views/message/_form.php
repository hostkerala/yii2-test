<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">    
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal','enctype'=>'multipart/form-data']]); ?>    
    <?php echo $form->field($messageForm, 'topicId')->hiddenInput(['value'=>$messageForm->topicId])->label(false) ?>
    <?php echo $form->field($messageForm, 'userId')->hiddenInput(['value'=>$messageForm->userId])->label(false) ?>
    <?php echo $form->field($messageForm, 'message_to')->hiddenInput(['value'=>$messageForm->message_to])->label(false) ?>
    <div class="form-group"
        <label class="pull-left"><b>Reply</b></label>
    </div>
    <?php echo $form->field($messageForm, 'content')->textArea(['rows' => '6','placeholder' => 'Write your message here'])->label(false) ?>
    <?php echo $form->field($messageForm, 'attach_file')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*','showUpload' => false,],
            ]);
    ?>
    
    <div class="form-group">
       <?= Html::submitButton('Send', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<a id="jump-to"></a>
</hr>
