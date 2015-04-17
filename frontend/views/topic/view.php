<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Controller;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'topic_end',
            'user_id',
            'title',
            'status',
            'thumbnail',

        ],
    ]) ?>

</div>

<hr>
<h2>Comments (<?php echo count($model->comments); ?>)</h2>
<?php	if((((Yii::$app->user->id != $model->user_id) && ($postComment ))) || yii::$app->user->identity->isAdmin) { //Admin Have all Rights?>
	<?php	echo $this->render('comments/_form', array('model'=>$model, 'comment' => $comment)); ?>
<?php   } ?>
<hr />
<?php echo $this->render('comments/_list', array('model'=>$model)); ?>
<?php if($authorTopics->getCount() > 0 ) : ?>
<h2> Other My Topics ( <?php echo $authorTopics->getCount(); ?>)</h2>
<?php  echo $this->render('comments/_author_topics',array('authorTopics'=>$authorTopics)) ?>
<?php endif; ?>
