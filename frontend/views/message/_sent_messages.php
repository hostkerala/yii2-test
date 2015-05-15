<?php

use yii\helpers\Url;

?>
<ul class="media-list">
    <li class="media-left">
      <div class="media-body">
        <h4 class="media-heading">Sent Messages</h4></h4>
      </div>
    </li>
    <hr>
    <div class="col-md-12">        
        <?php 
        if(!empty($model)) :  
             foreach($model as $topic): ?>
                <?php if(count($topic->comments) > 0): ?>
                    <?php    
                         $lastComment = $topic->comments[count($topic->comments)-1];                                
                         if($lastComment->userId == yii::$app->user->id) :                               
                     ?>
                         <a href="<?= Url::to(['/message/index','id'=>$topic->id]);  ?>">
                         <li class="media-left">
                             <div class="col-md-9 pull-left">                    
                                 <div id="messages" class="media-body">
                                     <div class="message-summary media"><b><?php echo $topic->title." (".count($topic->comments).")"?></b>
                                     <p class="text-muted"><?php  echo $lastComment->content;  ?></p>
                                     </div>
                                 </div>
                             </div>
                         </li>
                         </a>       
                         <hr>
                     <?php  endif; ?>
               <?php endif; ?>
            <?php endforeach; ?>   
        <?php endif; ?> 
    </div>
</ul>  
<hr>