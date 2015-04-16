<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ZipareasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zipareas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zipareas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Zipareas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'zip',
            'state',
            'city',
            'latitude',
            // 'longitude',
            // 'old_lng',
            // 'old_lat',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
