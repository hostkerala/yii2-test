<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use backend\models\Standard;
use frontend\assets\AppAsset;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php  AppAsset::register($this);  ?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p class="pull-right">
        <?= Html::a('Post Topic', ['create'], ['class' => 'btn btn-lg btn-success']) ?>
    </p>
    <br />

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'value' => function ($model) {                      
                    return $model->title;
                },  
            'contentOptions'=>['style'=>'max-width: 100px;word-wrap: break-word;']                         
            ],             
            [
                'attribute' => 'content',
                'value' => function ($model) {                      
                    return $model->content;
                },  
            'contentOptions'=>['style'=>'max-width: 150px;word-wrap: break-word;']                         
            ], 
            
            
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
                    return common\models\Categories::find()->where(['id'=>$model->category_id])->one()->name;
                },                
                'filter'=>Html::dropDownList('TopicSearch[category_id]', $searchModel->category_id, ArrayHelper::map(common\models\Categories::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt'=>'All']),
                'filterInputOptions' => ['class'=>'form-control'],  
            ],                          
            [
                'attribute' => 'skills',
                'value' => function ($model) {                      
                    return \common\models\Skill::getTopicSkill($model->id);
                },                
                'filter'=>Html::dropDownList('TopicSearch[skills]', $searchModel->skills, ArrayHelper::map(common\models\Skill::find()->asArray()->all(), 'id', 'name'),['prompt'=>'All','class'=>'form-control']),
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