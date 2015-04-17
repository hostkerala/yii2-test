<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\base\Controller;
use yii\timeago\TimeAgo;
use frontend\assets\AppAsset;
use yii\base\View;

AppAsset::register($this);

//date_default_timezone_set(yii::$app->params['timeZone']);


?>
<div  id="comment-list">
<?php foreach($model->comments as $comment): ?>            
<hr />
<div class="flag-icon flag-icon-Ru flag-style"></div>

<div class="row">	   
    <div class="span5"><?php $country = $comment->user->state->country;   ?>                    
        <h3 class="text-info"><?php echo $comment->user->username ?>&nbsp;<div class=" flag-icon flag-icon-<?= strtolower(($country->country_iso_2) ? $country->country_iso_2 : "gr") ?> flag-style"></div>&nbsp;<small><?= TimeAgo::widget(['timestamp' => $comment->createdAt]); ?></small></h3>
        <?php if(common\models\Topic::isAuthor($comment->topicId) || yii::$app->user->identity->isAdmin) {  //Admin Have all Rights ?> 
        <a class=" pull-right delete-button" href="<?php  echo Url::to(['comments/delete','id'=>$comment->id]); ?>" class="close" aria-label="Close"
            <span aria-hidden="true">&times;</span>                           
        </a>
        <?php } ?> 
    </div>
        <div class="span2 pull-left" style="padding-right:15px;">
            <img src="http://gravatar.com/avatar/<?= $comment->user->profile->gravatar_id ?>?s=150" class="img-rounded" alt="<?= $user->username ?>"/>
        </div>
        <div class="span9"> 
         <?php if(common\models\Topic::isAuthor($comment->topicId) || ($comment->userId == yii::$app->user->id) || yii::$app->user->identity->isAdmin) { //Admin Have all Rights ?>
            <div class="span9 text-justify">                       
                <p class="text-muted"><?php  echo Html::decode($comment->content)?></p>			                                          
            </div>
        <?php  }  else   { ?>
            <div class="span9 text-justify">                       
                <p class="text-muted">No access to read comments</p>	                                          
            </div>

        <?php } ?>
        </div> 
</div>
 <?php endforeach; ?>
</div>
<?php
/*$this->registerJs("$(document).ready(function() {        
        setInterval(ajaxCall, 3000); // Request in every 30 seconds
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
    );");*/
?>
