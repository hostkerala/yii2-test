<ul class="media-list">
    <li class="media-left">
      <div class="media-body">
        <h4 class="media-heading"><?= Messages ?></h4></h4>
      </div>
    </li>
    <hr>
    <div class="col-md-12">        
        <?php 
        if(!empty($model->sortedMessages)) :   
            foreach($model->sortedMessages as $message): ?>    
            <?php if(count($message) > 0): ?>
            <li class="media-left">
                <?php if(yii::$app->user->id == $message->user->id) { ?>
                <div class="col-md-3 pull-left">
                    <h4 class="text-left text-success"><?= Me ?></h4><p><?= date('M d, Y h:i:s',  strtotime($message->createdAt))  ?></p>
                </div>
                <?php } else { ?>
                <div class="col-md-3 pull-left">
                    <h4 class="text-left text-danger"><?= $message->user->username ?></h4><p><?= date('M d, Y h:i:s',strtotime($message->createdAt))  ?></p>
                </div>
                <?php } ?>
                <div class="col-md-9 pull-right">                    
                    <div id="messages" class="media-body">
                        <div class="message-summary media"><?= $message->content ?></div>
                        <?php if($message->attach_file): ?>
                        <p><a target="_blank"href="<?= Yii::$app->urlManager->baseUrl . '/uploads/messages/' . $message->attach_file ?>">Attached File</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
            <hr>
            <?php  endif; ?> 
            <?php  endforeach; ?>   
        <?php  endif; ?> 
    </div>
</ul>  
<hr>