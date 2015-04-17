<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

?>
<?php $this->title = "Users List"; ?>
<div class="user-view">
   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            'username',
            'created_at',
        ],
    ]) ?>

</div>
