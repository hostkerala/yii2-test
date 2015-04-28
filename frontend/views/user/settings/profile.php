<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;



/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>
<div class="row">
    <br />
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal','enctype'=>'multipart/form-data'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>                
                
                <div class="row">
                    <label class="col-lg-3 control-label">&nbsp;</label>
                        <div class="col-lg-9">
                        <?php echo $model->DisplayImage; ?>
                        </div>
                </div>
              
                <?php 
                // profile.php
                // display your image or a placeholder first
                if (empty($model->avatar)) {
                    echo $form->field($model, 'avatar')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*','showUpload' => false,],
                    ]);
                }
                else {
                    echo '<br /><div class="row"><div class="col-lg-12">';
                    echo Html::a(
                        Yii::t('app', 'Remove Image'), 
                        Url::to(['/user/settings/remove','id'=>$model->id]),
                        ['class' => 'btn btn-danger pull-right']
                    );
                    echo '</div></div><br />';
                }
                ?>
                
                <?php
                    
                $model->country_id = 11; //Default country id (INDIA) - When edit the country first time.
                
                if($model->state->country->id)
                {
                    $model->country_id = $model->state->country->id;
                }
                
                    $dataCountry=ArrayHelper::map(\common\models\Countries::find()->asArray()->all(), 'id', 'country_name_en');
                    echo $form->field($model, 'country_id')->dropDownList(
                        $dataCountry       
                    ); 
                ?>
                <?php
                
                $state_default = [12 => 'Kerala']; 
                
                if($model->state->id)
                {
                    
                    $state_default=[];
                    $state_default[$model->state->id] = $model->state->state_name_en;
                }                
                
                // States
                echo $form->field($model, 'state_id')->widget(DepDrop::classname(), [
                    'data' => $state_default, // ensure at least the preselected value is available
                    'pluginOptions'=>[
                        'depends'=>[Html::getInputId($model, 'country_id')], // the id for cat attribute
                        'placeholder'=>'-Select State-',
                        'url'=>Url::to(['/user/settings/states'])
                    ]
                ]);
                ?>
                
                <?php
                
                $city_default = ['6' => 'Kasargod'];
                
                if($model->city->id)
                {
                    
                    $city_default=[];
                    $city_default[$model->city->id] = $model->city->city;
                }    
                
                // Cities
                echo $form->field($model, 'city_id')->widget(DepDrop::classname(), [
                    'data' => $city_default, // ensure at least the preselected value is available
                    'pluginOptions'=>[
                        'depends'=>[
                            Html::getInputId($model, 'country_id'), 
                            Html::getInputId($model, 'state_id'), 
                        ],
                        'placeholder'=>'-Select Citiy-',
                        'url'=>Url::to(['/user/settings/city']),
                        'initialize'=>true
                    ]
                ]);
                
                
                ?>  
                
                
                <div class="form-group">
                    <label class="col-lg-3 control-label">Skills</label>
                    <div class="col-lg-9">
                        <?php
                        $model->skills = common\models\Profile::getUserSkills(yii::$app->user->id);
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
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn  btn-primary']) ?><br>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
