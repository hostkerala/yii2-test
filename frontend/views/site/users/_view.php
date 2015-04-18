<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\States;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

?>
<?php $this->title = "Users List"; ?>
<div class="user-view">
   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            [
                'attribute'=>'state_id',
                'value'=>$model->state->state_name_en,
            ],
            [
                'attribute'=>'city',
                'value'=>$model->city->city,
            ],
            [
                'attribute'=>'skills',
                'value'=>$model->userSkillsString?$model->userSkillsString: null,   
            ]
            //'skills'
        ],
    ]) ?>

</div>
