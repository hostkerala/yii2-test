<?php

use yii\helpers\Url;

?>

<div class="list-group"> 
    <a href="<?= Url::to(['/message/inbox']);  ?>" class="list-group-item list-group-item-info">Inbox</a>
    <a href="<?= Url::to(['/message/sent']);  ?>" class="list-group-item list-group-item-info">Sent</a>
</div> 

