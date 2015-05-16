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
            <?php echo $this->render('_message_menu'); ?>
        </div>
        <div class="col-md-9">
            <div id="message-panel" class="col-md-12">
                <?php echo $this->render('_message', ['model'=>$model]); ?>
            </div>
            <div class="row">
            <div class="col-md-12">
                <?php if(count($model->comments) > 0) { ?>                
                <?php echo $this->render('_form', ['model'=>$model, 'messageForm' => $messageForm]); ?>
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