<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($commentForm, 'topicId')->hiddenInput(['value'=>$model->id])->label(false) ?>
    <?php echo $form->field($commentForm, 'content')->textArea(['rows' => '6','placeholder' => 'Write your message here'])->label(false) ?>
    
    <div class="form-group">
       <?= Html::submitButton('Send', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<a id="jump-to"></a>
</hr>
