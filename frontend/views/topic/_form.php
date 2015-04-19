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
    'dateFormat' => 'MM/dd/yyyy',
    'clientOptions'=>[
    'changeMonth' => 'true',
    'changeYear' => 'true',
    'showButtonPanel' => 'true',
    'constrainInput' => 'false',
    'duration' => 'fast',
    'showAnim' => 'slide',
     ],
    'options'=>['class'=>'form-control']
    ]) ?> 
    <?php
    $dataCategory=ArrayHelper::map(\common\models\Categories::find()->asArray()->all(), 'id', 'name');
    echo $form->field($model, 'category_id')->dropDownList(
        $dataCategory       
    );
    ?>
    <?php
    $model->skills = common\models\Skill::getTopicSkill($model->id);
    echo '<label class="control-label">Skills</label>';
    $skills  = ArrayHelper::getColumn(\common\models\Skill::find()->select('name')->all(), 'name');
    echo Select2::widget([
        'model' => $model,
        'attribute' => 'skills',        
        'name' => 'Skills',
        //'value' => common\models\Skill::getTopicSkill($model->id),
        'pluginOptions' => [
            'tags' => $skills,
            'maximumInputLength' => 10
        ],
        'options' => [
            'placeholder' => 'desciplines',
            'class' => 'form-control',
            'multiple' => true,
            'tokenSeparators' => array(',', ' '),
        ],
    ]);
    ?>
    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<?php
//$topicSkills = common\models\Skill::getTopicSkill($model->id);
//$this->registerJs("$(document).ready(function () {
       // $('#Skills').val('$topicSkills');
   // });");
?>
