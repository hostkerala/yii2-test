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
                <a href="<?= Url::to(['/topic/index']);  ?>" class="list-group-item list-group-item-info">Go to Topic Page</a>
            </div>    
        </div>
        <div class="col-md-9">
            <div id="message-panel" class="col-md-12">
                <?php echo $this->render('_inbox_messages', ['model'=>$model]); ?>
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
              url: '".Url::to(['message/inboxlist'])."',
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