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
<hr />
<div  id="comment-list">
    <?php foreach($model->comments as $comment): ?>  
        <div class="media">
            <?php $country = $comment->user->state->country;   ?>
            <div class="media-left">
              <a href="#">
                  <img class="media-object" style="width: 64px; height: 64px;" data-src="http://gravatar.com/avatar/<?= $comment->user->profile->gravatar_id ?>?s=150" class="img-rounded" alt="<?= $user->username ?>"/>
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading" id="top-aligned-media"><?php echo $comment->user->username ?><a class="anchorjs-link" href="#top-aligned-media"><span class="anchorjs-icon"></span></a>&nbsp;<div class=" flag-icon flag-icon-<?= strtolower(($country->country_iso_2) ? $country->country_iso_2 : "gr") ?> flag-style"></div>&nbsp;<small><?= TimeAgo::widget(['timestamp' => $comment->createdAt]); ?></small>
             <?php if(common\models\Topic::isAuthor($comment->topicId) || yii::$app->user->identity->isAdmin) {  //Admin Have all Rights ?> 
                <a class=" pull-right delete-button" href="<?php  echo Url::to(['comments/delete','id'=>$comment->id]); ?>" class="close" aria-label="Close"
                    <span aria-hidden="true">&times;</span>                           
                </a>
            <?php } ?>
              </h4>
              <?php if(common\models\Topic::isAuthor($comment->topicId) || ($comment->userId == yii::$app->user->id) || yii::$app->user->identity->isAdmin) { //Admin Have all Rights ?>
              <p><?php  echo Html::decode($comment->content)?></p>
              <?php } else { ?>
              <p>No access to read comments</p>              
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
