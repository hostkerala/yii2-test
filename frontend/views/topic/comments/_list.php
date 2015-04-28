<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Controller;
use yii\timeago\TimeAgo;
use yii\helpers\Url;
?>
<h2>Comments (<?php echo count($model->comments); ?>)</h2>
<hr />
<?php foreach($model->sortedComments as $comment): ?>  
    <div class="media">
        <?php $country = $comment->user->state->country;   ?>
        <div class="media-left">
          <a href="#">
              <?php $image = is_null($comment->user->avatar) || empty($comment->user->avatar) ? 'default.jpg' : $comment->user->avatar; ?>
              <img class="media-object" style="width: 64px; height: 64px;" src="<?= Yii::$app->urlManager->baseUrl . '/uploads/' . $image ?>" class="img-rounded" alt="<?= $user->username ?>"/>
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading" id="top-aligned-media"><?php echo $comment->user->username ?><a class="anchorjs-link" href="#top-aligned-media"><span class="anchorjs-icon"></span></a>&nbsp;<div class=" flag-icon flag-icon-<?= strtolower(($country->country_iso_2) ? $country->country_iso_2 : "gr") ?> flag-style"></div>&nbsp;<small><?= TimeAgo::widget(['timestamp' => strtotime($comment->createdAt)]); ?></small>
         <?php if(common\models\Topic::isAuthor($comment->topicId) || yii::$app->user->identity->isAdmin || (yii::$app->user->id == $comment->userId)) {  //Admin Have all Rights ?> 
            <a class=" pull-right delete-button" href="<?php  echo Url::to(['comments/delete','id'=>$comment->id]); ?>" class="close" aria-label="Close"
                <span aria-hidden="true">&times;</span>                           
            </a>
        <?php } ?>
          </h4>
          <?php if(common\models\Topic::isAuthor($comment->topicId) || ($comment->userId == yii::$app->user->id) || yii::$app->user->identity->isAdmin) { //Admin Have all Rights ?>
          <p class="text-muted"><?php  echo Html::decode($comment->content)?></p>
          <?php } else { ?>
          <p class="text-muted">No access to read comments</p>              
          <?php } ?>
        </div>
    </div>
    <hr />
<?php endforeach; ?>
