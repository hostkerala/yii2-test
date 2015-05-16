<?php

use yii\helpers\Url;
$listed = true;
$showTopic = true;
$showHeading = true;
$userArray[] = yii::$app->user->id;
?>
<div class="col-md-12">
<ul class="media-list">
    <li class="media-left">
      <div class="media-body">
        <h2 class="media-heading">Inbox</h4></h2><hr />
      </div>
    </li>
    <?php 
    if(!empty($model)) :  
        foreach($model as $topic): 
    ?>
    <li class="media well">
        <div class="media-body">
          <h4 class="media-heading"><?php echo $topic->content; ?></h4></h4>
            <div>
              <?php echo $this->render('_inbox_users', ['topic'=>$topic]); ?>
            </div>
        </div>
    </li>
    <?php 
    endforeach; 
    endif;   
    ?>
</ul>
</div>