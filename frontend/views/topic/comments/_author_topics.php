<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topics';

?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $authorTopics,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'content:ntext',
            ['class' => 'yii\grid\ActionColumn','template' => '{view}',   
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = Url::to(['topic/index'/*,'id'=>$model->id]*/]); 
                        return $url;
                    }
                }],
        ],
    ]); ?>

</div>
