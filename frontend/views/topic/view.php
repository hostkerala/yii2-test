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
    <?php if($model->user_id == yii::$app->user->id): ?>
        <div class="btn-group" role="group" aria-label="...">
            <a href=<?= Url::to(['/message/index','id'=>$model->id]);  ?>><button type="button" class="btn btn-lg btn-success">Send Messages</button></a>
        </div>
    <?php endif;  ?>
<div class="topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'template' => "<tr><th>{label}</th><td style='word-wrap:break-word;'>{value}</td></tr>",
        'attributes' => [
            'id',
            [
                'attribute' => 'created_at',
                'format'=>'raw',
                'value'=> date('M d, Y',$model->created_at),                
            ], 
            [
                'attribute' => 'topic_end',
                'format'=>'raw',
                'value'=> date('M d, Y',$model->topic_end),                 
            ],             
            [
                'attribute' => 'title',
                'format'=>'raw',
                'value'=> $model->title,                
            ],            
            'status',
            'thumbnail',

        ],
    ]) ?>
</div>
<?php	if((((Yii::$app->user->id != $model->user_id) && ($postComment ))) || yii::$app->user->identity->isAdmin) { //Admin Have all Rights?>
<?php	echo $this->render('comments/_form', array('model'=>$model, 'comment' => $comment)); ?>
<?php   } ?>
<hr>
<h2><?php echo "Content" ?></h2>
<hr>
<div class="row">
    <div class="col-md-12" style='word-wrap:break-word;'>
        <p><?php echo $model->content; ?></p>
    </div>
</div>
<div  id="comment-list">    
    <p><?php echo $this->render('comments/_list', array('model'=>$model)); ?></p>
</div>
<?php
    if($model->user_id == Yii::$app->user->id)
    {
       $otherTopicTitle =  "Other My Topics";
    }
    else
    {
        $otherTopicTitle =  "Other Author Topics";
    }
?>

<?php if($authorTopics->getCount()>0) : ?>
<h2><?= $otherTopicTitle ." (".$authorTopics->getCount().")"?></h2>
<?php  echo $this->render('comments/_author_topics',array('authorTopics'=>$authorTopics)) ?>
<?php  endif; ?>

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