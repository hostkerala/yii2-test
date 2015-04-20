<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\web\JsExpression;
use common\models\Topic;
use yii\jui\AutoComplete;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "Users List";

?>
<?php
$data = common\models\Skill::find()
 ->select(['name as value', 'name as  label','id as id'])
 ->asArray()
 ->all();
?>

<?= Html::beginForm(Url::to(['/site/users']),'get',['id'=>'skillFilter']) ?>
<br />
<?php
echo '<label class="control-label">Skills</label>';
$skills  = ArrayHelper::map( \common\models\Skill::find()->all(),'id','name');
echo Select2::widget([
    'model' => $model,
     'attribute' => 'skills', 
    'data'=>$skills,
    'name' => 'skill',
    'options' => [
        'placeholder' => 'desciplines....',
        'onChange'=>"$('#skillFilter').submit()",
        'class' => 'form-control',
        'style'=>'width:200px',
        'tokenSeparators' => array(',', ' '),
    ],
]);
?>
<br />
<?= Html::endForm() ?>

<?php if(Yii::$app->request->get('skill')): ?>    
    <div class="btn-group" role="group" aria-label="...">
        <a href=<?= Url::to(['/site/users']);  ?>><button type="button" class="btn btn-success">Reset Filter</button></a>
    </div>
<?php  endif; ?>

 Specialization: <?php echo Yii::$app->request->get('skill') ? \common\models\Skill::find()->where(['id'=>Yii::$app->request->get('skill')])->one()->name : 'All'; ?>
<div class="user-index">
    <h1><?= $this->title ?></h1>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view'
    ]) ?>

</div>

