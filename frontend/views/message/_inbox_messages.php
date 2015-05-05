<?php

use yii\helpers\Url;

?>
<ul class="media-list">
    <li class="media-left">
      <div class="media-body">
        <h4 class="media-heading"><?= Inbox ?></h4></h4>
      </div>
    </li>
    <hr>
    <div class="col-md-12">        
        <?php 
        if(!empty($model)) :  
             foreach($model as $topic): ?>    
            <a href="<?= Url::to(['/message/index','id'=>$topic->id]);  ?>"<li class="media-left">
                <div class="col-md-9 pull-left">                    
                    <div id="messages" class="media-body">
                        <div class="message-summary media"><?= $topic->title;?></div>
                    </div>
                </div>
                </li>
            </a>
            <hr>
            <?php  endforeach; ?>   
        <?php  endif; ?> 
    </div>
</ul>  
<hr>