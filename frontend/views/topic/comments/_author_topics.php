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
            [
                'attribute' => 'content',
                'value' => function ($model) {                      
                    return $model['content'];
                },  
            'contentOptions'=>['style'=>'max-width: 150px;word-wrap: break-word;']                         
            ], 
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
