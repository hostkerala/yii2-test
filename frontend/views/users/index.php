<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\web\JsExpression;
use kartik\select2\Select2;
use common\models\Topic;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Users List";
$model = new  Topic;
?>
<?php

echo Html::beginForm() ?>
 

<?php

// TypeaheadBasic usage with ActiveForm and model
echo $form->field($model, 'skills')->widget(Typeahead::classname(), [
    'data' => array_merge(["" => ""], \common\models\Skill::getAllSkill()),
    'pluginOptions' => ['highlight' => true],
    'options' => ['placeholder' => 'begin write skill ...'],
]);
?>
<?= Html::endForm() ?>
<?php  if(Yii::app()->request->getQuery('skill')){ ?>
    <a href=<?= Url::to(['/site/users']);  ?>><button type="button" class="btn btn-success">Reset Filter</button></a>
<?php  } ?>
Specialization: <?php echo Yii::app()->request->get('skill')?Yii::app()->request->get('skill'): 'All'; ?>
<div class="user-index">
    <h1><?= $this->title ?></h1>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view'
    ]) ?>

</div>
