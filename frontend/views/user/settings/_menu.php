<?php

use yii\widgets\Menu;

$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?php
            $user = common\models\Profile::find()->where(['id'=>yii::$app->user->id])->one();
            ?>
            <?php $image = is_null($user->avatar) || empty($user->avatar) ? 'default.jpg' : $user->avatar; ?>
            <img src="<?= Yii::$app->urlManager->baseUrl . '/uploads/'.$image ?>" class="img-rounded" alt="<?= Yii::$app->urlManager->baseUrl . '/uploads/'.$image ?>" height="25" width="25"/>
            <?= $user->username ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked'
            ],
            'items' => [
                ['label' => Yii::t('user', 'Profile'),  'url' => ['/user/settings/profile']],
                ['label' => Yii::t('user', 'Change Password'),  'url' => ['/user/settings/account']],
                //['label' => Yii::t('user', 'Networks'), 'url' => ['/user/settings/networks'], 'visible' => $networksVisible],
            ]
        ]) ?>
    </div>
</div>