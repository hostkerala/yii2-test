<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
        
            $menuItems  = [ 
                ['label' => 'Home', 'url' => ['/site/index']], 
                ['label' => 'Admin Panel', 'url' => Yii::$app->urlManagerBackend->createUrl('/'),'visible' => yii::$app->user->identity->isAdmin], 
                [
                    'label' => 'Welcome, '.Yii::$app->user->identity->username,
                    'url' => '#',
                    'template' => '<a href="{url}" class="dropdown-toggle" data-toggle="dropdown">{label} <i class="icon-angle-down"></i></a>',
                    'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                        [
                            'label' => 'Profile',
                            'url' => ['/user/settings/profile'],                            
                        ],
                        [
                            'label' => 'Logout',
                            'url' => ['/user/security/logout'],
                            'linkOptions' => ['data-method' => 'post'],
                        ],
                    ]
                ],    
                ['label' => 'Login', 'url' => ['/user/security/login'],'visible' => Yii::$app->user->isGuest],  
                ['label' => 'Register', 'url' => ['/user/registration/register'],'visible' => Yii::$app->user->isGuest],                               
            ];
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?php if(yii::$app->user->id): ?>
        <div class="btn-group" role="group" aria-label="...">
            <a href=<?= Url::to(['/users/index']);  ?>><button type="button" class="btn btn-primary">Users</button></a>
            <a href=<?= Url::to(['/topic/index']);  ?>><button type="button" class="btn btn-default">Topics</button></a>            
        </div>
        <?php endif; ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
