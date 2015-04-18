<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use backend\models\Standard;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Post Topic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'content:ntext',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {                      
                    return $model->created_at;
                },  
                'format' => 'date',
                'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'dateFormat' => 'MM/dd/yyyy',                                            
                       ]
                     ),
            ],                      
            [
                'attribute' => 'category_id',
                'value' => function ($model) {                      
                    return common\models\Categories::find(['id'=>$model->category_id])->one()->name;
                },                
                'filter'=>Html::dropDownList('TopicSearch[category_id]', null, ArrayHelper::map(common\models\Categories::find()->all(), 'id', 'name'),['prompt'=>'All','class'=>'form-control']),
                'filterInputOptions' => ['class'=>'form-control'],  
            ],                          
            [
                'attribute' => 'skills',
                'value' => function ($model) {                      
                    return $model->skills->name;
                },                
                'filter'=>Html::dropDownList('skills', null, ArrayHelper::map(common\models\Skill::find()->all(), 'id', 'name'),['prompt'=>'All','class'=>'form-control']),
                'filterInputOptions' => ['class'=>'form-control'],  
            ],      
            [
            'attribute' => 'topic_end',
            'format' => 'raw',                   
            'value' => function ($model) {                      
                    return $model->topic_end;
            },
            'format' => 'date',
            'filter' => DatePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'topic_end',
                                            'dateFormat' => 'MM/dd/yyyy',  
                                           ]
                                         ),
            'filterInputOptions' => ['class'=>'form-control'],  
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
