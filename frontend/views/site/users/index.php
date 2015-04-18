<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\web\JsExpression;
use common\models\Topic;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "Users List";

?>

<?= Html::beginForm(Url::to(['/site/users']),'get',['id'=>'skillFilter']) ?>
<br />
<?php
echo '<label class="control-label">Filter Skills</label><br />';
echo AutoComplete::widget([
    //'model' => $model,
    //'attribute' => 'country',,
    'clientOptions' => [
        'source'=>Url::to(['site/skills']),
         'change'=>"js:function(event, ui) {
            $('#skillFilter').submit()
           }",
        ],
    'options'=>[
        'class'=>'form-control', 
        'style'=>'width:200px;',
        'placeholder'=>'begin write skill..',
        'name'=>'skill',
        'value'=>''
        ],
]);
?>
<br />
<?= Html::endForm() ?>

<?php if(Yii::$app->request->getQueryParam('skill')): ?>    
    <div class="btn-group" role="group" aria-label="...">
        <a href=<?= Url::to(['/site/users']);  ?>><button type="button" class="btn btn-success">Reset Filter</button></a>
    </div>
<?php  endif; ?>


<div class="user-index">
    <h1><?= $this->title ?></h1>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view'
    ]) ?>

</div>

