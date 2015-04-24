<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="topic-index">
    
    <?= GridView::widget([
        'dataProvider' => $authorTopics,
        'summary'=>"",
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'content:ntext',
            ['class' => 'yii\grid\ActionColumn','template' => '{view}',   
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') { 
                        $url = Url::to(['topic/view','id'=>$model['id']]); 
                        return $url;
                    }
                }],
        ],
    ]); ?>

</div>
