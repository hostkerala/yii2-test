<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\widgets\Menu;

/** @var dektrium\user\models\User $user */
$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?php
            $user = common\models\Profile::find()->where(['id'=>yii::$app->user->id])->one();
            ?>
            <?php $image = is_null($user->avatar) || empty($user->avatar) ? 'default.jpg' : $image; ?>
            <img src="<?= Yii::$app->urlManager->baseUrl . '/uploads/'.$image ?>" class="img-rounded" alt="<?= Yii::$app->urlManager->baseUrl . '/uploads/'.$user->avatar ?>" height="25" width="25"/>
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