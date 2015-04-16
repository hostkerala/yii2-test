<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Zipareas */

$this->title = 'Create Zipareas';
$this->params['breadcrumbs'][] = ['label' => 'Zipareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zipareas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
