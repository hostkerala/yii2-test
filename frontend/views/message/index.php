<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Controller;
use frontend\assets\AppAsset;
use yii\base\View;
use yii\helpers\Url;
?>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-3">
            <div class="list-group"> 
                <a href="<?= Url::to(['/topic/view','id'=>$model->id]);  ?>" class="list-group-item list-group-item-info">Go to Topic Page</a>
                <a href="<?= Url::to(['/message/inbox']);  ?>" class="list-group-item list-group-item-info">Inbox</a>
                <a href="#jump-to" class="list-group-item list-group-item-info"> Reply to Message</a>
            </div>    
        </div>
        <div class="col-md-9">
            <div id="message-panel" class="col-md-12">
                <?php echo $this->render('_message', ['model'=>$model]); ?>
            </div>
            <div class="row">
            <div class="col-md-12">
                <?php if($model->comments->count > 0) { ?>
                <h4>Reply</h4>
                <?php echo $this->render('_form', ['model'=>$model, 'commentForm' => $commentForm]); ?>
                <?php } else { ?>
                <p class="text-muted">No Messages</p>   
                <?php } ?>
            </div>   
            </div>
        </div>        
    </div>
</div>
<hr>

<?php
$this->registerJs("$(document).ready(function() {        
        setInterval(ajaxCall, 30000); // Request in every 30 seconds
        function ajaxCall() {            
            $.ajax({
              url: '".Url::to(['message/list','id'=>$model->id])."',
              cache: false
            })
              .done(function( html ) {
                $( '#message-panel' ).empty();
                $( '#message-panel' ).append( html );
              });

        }
    }
    );");
?>