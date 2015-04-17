<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\web\JsExpression;
use kartik\select2\Select2;
use common\models\Topic;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Users List";
$data = ['qwe1'=>'color1','key2'=>'color3'];
$model = new  Topic;
?>

<?= Html::beginForm() ?>
<?php
       echo '<br />';
       echo '<label class="control-label">Filter By Skills</label>';
       echo Select2::widget([
        'model' => $model,
        'attribute' => 'skills',
        'name' => 'Skills',
        'data' => array_merge(["" => ""], \common\models\Skill::getAllSkill()),
        'options' => [
            'placeholder' => 'begin write skill ...',
            'class' => 'form-control',
            'style'=>'width:200px;',
            'multiple' => true,
            'tokenSeparators' => array(',', ' '),
        ],
    ]);
?>
<br />
<?= Html::endForm() ?>

<div class="user-index">
    <h1><?= $this->title ?></h1>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view'
    ]) ?>

</div>
