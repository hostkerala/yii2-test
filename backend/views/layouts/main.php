<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

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
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
           $menuItems = [                 
                [
                    'label' => 'Actions',
                    'url' => '#',
                    'template' => '<a href="{url}" class="dropdown-toggle" data-toggle="dropdown">{label} <i class="icon-angle-down"></i></a>',
                    'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                        [
                            'label' => 'Users',
                            'url' => ['/user/admin/index'],                            
                        ],
                        [
                            'label' => 'Pages',
                            'url' => ['/pages/index'],
                        ],
                        [
                            'label' => 'Settings',
                            'url' => ['/settings/index'],
                        ],                        
                    ]
                ],                
                [
                    'label' => 'Admin',
                    'url' => '#',
                    'template' => '<a href="{url}" class="dropdown-toggle" data-toggle="dropdown">{label} <i class="icon-angle-down"></i></a>',
                    'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                        ['label' => 'Back to Site', 'url' => Yii::$app->urlManagerFrontend->createUrl('/')], 
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
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4>Navigation</h4>
                    </div>
                    <div class="panel-body">  
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked'
                    ],
                    'items' => [
                        ['label' => 'Users', 'url' => ['/user/admin/index']],
                        [
                            'label' => 'Pages', 'url' => '#',
                            'items' => 
                            [
                                ['label' => 'Create', 'url' => ['/pages/create']],
                                ['label' => 'List', 'url' => ['/pages/index']],
                            ],
                        ],  
                        [
                            'label' => 'Settings',  'url' => ['/settings/index'],
                            
                        ],                        
                    ]
                ]) ?>                        
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">  
                        <h4>Admin Panel</h4>
                    </div>
                    <div class="panel-body">  
                    <?= $content ?>
                    </div>
                </div>
            </div> 
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
