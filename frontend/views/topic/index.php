<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Topic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'content:ntext',
            [
            'attribute' => 'category_id',
            'format' => 'raw',
            'filter'=>common\models\Categories::dropdown(),
            ], 
            /*[
            'attribute' => 'created_at',
            'format' => 'raw',                   
            'value' => function ($model) {                      
                    return Yii::$app->formatter->asDate($model->created_at, "yyyy-MM-dd");
            },
            'filter' => DatePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'created_at',
                                            'dateFormat' => 'yyyy-MM-dd',                                            
                                           ]
                                         ),
            'filterInputOptions' => ['class'=>'form-control'],  
            ],*/           
            [
            'attribute' => 'topic_end',
            'format' => 'raw',                   
            'value' => function ($model) {                      
                    return Yii::$app->formatter->asDate($model->topic_end, "yyyy-MM-dd");
            },

            'filter' => DatePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'topic_end',
                                            'dateFormat' => 'yyyy-MM-dd',                                            
                                           ]
                                         ),
            'filterInputOptions' => ['class'=>'form-control'],  
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
