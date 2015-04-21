<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Controller;
use frontend\assets\AppAsset;
use yii\base\View;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php  AppAsset::register($this);  ?>

<div class="topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'topic_end',
            //'user_id',
            'title',
            'status',
            'thumbnail',

        ],
    ]) ?>

</div>

<hr>
<h2>Comments (<?php echo count($model->comments); ?>)</h2>
<div  id="comment-list">
    <?php	if((((Yii::$app->user->id != $model->user_id) && ($postComment ))) || yii::$app->user->identity->isAdmin) { //Admin Have all Rights?>
            <?php	echo $this->render('comments/_form', array('model'=>$model, 'comment' => $comment)); ?>
    <?php   } ?>
    <?php echo $this->render('comments/_list', array('model'=>$model)); ?>
</div>
<?php if($authorTopics) : ?>
<h2> Other My Topics ( <?php echo $authorTopics->getCount(); ?>)</h2>
<?php  echo $this->render('comments/_author_topics',array('authorTopics'=>$authorTopics)) ?>
<?php endif; ?>

<?php
$this->registerJs("$(document).ready(function() {        
        setInterval(ajaxCall, 30000); // Request in every 30 seconds
        function ajaxCall() {            
            $.ajax({
              url: '".Url::to(['topic/list','id'=>$model->id])."',
              cache: false
            })
              .done(function( html ) {
                $( '#comment-list' ).empty();
                $( '#comment-list' ).append( html );
              });

        }
    }
    );");
?>