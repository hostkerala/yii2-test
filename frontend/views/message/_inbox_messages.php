<?php

use yii\helpers\Url;
$listed = true;
$showTopic = true;
$userArray[]="";
?>
<ul class="media-list">
    <li class="media-left">
      <div class="media-body">
        <h4 class="media-heading">Inbox</h4></h4>
      </div>
    </li>
    <hr>
    <div class="col-md-12">        
        <?php 
        if(!empty($model)) :  
             foreach($model as $topic): ?>
                <?php if(count($topic->messages) > 0): ?>                    
                <?php
                foreach($topic->messages as $messages)
                {
                ?>                
                            <?php                            
                            $userId = $messages->userId;
                            foreach($topic->messages as $userMessages)
                            {?>
                                <li class="media">
                                    <div class="col-md-9 pull-left">                    
                                        <div id="messages" class="media-body well">
                            <?php                               
                                
                                if($userMessages->userId == $userId)
                                { 
                                    if($showTopic):   
                                    $showTopic = false;
                                ?>
                                <div class="message-summary media"><b><?php echo $topic->title." (".count($topic->messages).")"?></b></div>
                                <?php endif;  ?>
                                
                                <?php
                                    $printed = in_array($userId,$userArray);
                                    if(($userId == $userMessages->message_to) || ($userMessages->userId == $userId) && $printed !=1 )
                                    { 
                                        if($listed)
                                        {
                                            $listed = false;
                                        ?>
                                            <a href="<?= Url::to(['/message/index','topicId'=>$userMessages->topicId,
                                                                    'toUser'=>$userMessages->message_to, 
                                                                    'userId'=>yii::$app->user->id]
                                                    );  ?>">
                                            <p><?php echo $userMessages->user->username  ?></p>
                                            <hr /> 
                                            <p class="text-muted"><?php  echo $userMessages->content;  ?></p>
                                            </a>
                                            <hr /> 
                                        <?php
                                        }
                                        ?>                                                                           
                                    <?php
                                    }
                                }
                            }
                            $userArray[]=$userId;
                            $listed = true;
                            ?>                            
                        </div>
                    </div>
                 </li>                
                <?php                        
                }                
                ?>
                <hr>
               <?php endif; ?>
            <?php $showTopic = true; ?>
            <?php endforeach; ?>   
        <?php endif; ?> 
    </div>
</ul>  
<hr>