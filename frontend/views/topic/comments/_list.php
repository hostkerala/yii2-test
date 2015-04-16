<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\base\Controller;
use yii\timeago\TimeAgo
?>


<?php foreach($model->comments as $comment): ?>            
<hr />
<div class="row" id="comment-list">	   
		<div class="row" style="height:20px;"><?php $country = $comment->user->state->country;   ?>                    
                    <div class="text-info"><?php echo $comment->user->username ?>&nbsp;<div class="flag-icon flag-icon-<?php= $country->country_iso_2 ?> flag-style"></div>&nbsp;<small><?= TimeAgo::widget(['timestamp' => $model->createdAt]); ?></small></div>
                    <?php if(common\models\Topic::isAuthor($comment->topicId) || yii::$app->user->identity->isAdmin) {  //Admin Have all Rights ?> 
                    <a class=" pull-right delete-button" href="<?php  echo Url::to(['comments/delete','id'=>$comment->id]); ?>" class="close" aria-label="Close"
                        <span aria-hidden="true">&times;</span>                           
                    </a>
                    <?php } ?> 
                </div>
                <div class="row">
                    <div class="span2 pull-left">
                        <img src="<?php= $comment->user->avatar; ?>" alt=".." height="150px" width="150px">
                    </div>
                    <div class="span10 pull-left"> 
                     <?php if(common\models\Topic::isAuthor($comment->topicId) || ($comment->userId == yii::$app->user->id) || yii::$app->user->identity->isAdmin) { //Admin Have all Rights ?>
                        <div class="span10 pull-left text-justify">                       
                            <p class="text-muted"><?php  echo Html::decode($comment->content)?></p>			                                          
                        </div>
                    <?php  }  else   { ?>
                        <div class="span10 pull-left text-justify">                       
                            <p class="text-muted">No access to read comments</p>	                                          
                        </div>
                        	
                    <?php } ?>
                    </div> 
                </div> 
</div>
 <?php endforeach; ?>

<style>
    .flag-style
    {        
        height:20px;
        width:20px; 
        vertical-align:middle;
    }
</style>   