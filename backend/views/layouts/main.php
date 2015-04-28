<?php

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 24-04-2015
* Time :3:00 PM
*/

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php AppAsset::register($this); ?>

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
                    ['label' => 'Back to Site', 'url' => Yii::$app->urlManagerFrontend->createUrl('/'),'visible' => Yii::$app->user->isGuest],  
                ];
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-left'],
                    'items' => $menuItems,
                ]);
                NavBar::end();
            ?>

            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>       
            <div class="container">
                <?php if(yii::$app->user->identity->isAdmin): ?>
                <div class="col-md-2">
                    <div class="list-group">                    
                        <a href="#" class="list-group-item disabled">
                          <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                          Users
                        </a>
                        <a href="<?= Url::to(['/user/admin/index']) ?>" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> List</a>
                        <a href="<?= Url::to(['/user/admin/create']) ?>" class="list-group-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</a>
                        <a href="#" class="list-group-item disabled">
                          <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Pages
                        </a>
                        <a href="<?= Url::to(['/pages/index']) ?>" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> List</a>
                        <a href="<?= Url::to(['/pages/create']) ?>" class="list-group-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</a>
                        <a href="#" class="list-group-item disabled">
                          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings
                        </a>   
                        <a href="<?= Url::to(['/settings/index']) ?>" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> List</a>                  
                    </div>    
                </div>
                <?php  endif;  ?>
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">  
                            <h4><span class="glyphicon glyphicon-plane" aria-hidden="true"></span> Admin Panel</h4>
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
            <p class="powered">
                Powered by <a target="_blank" href="#">TEST</a> &copy;. All rights reserved.
            </p>
            </div>
        </footer>
        
        <?php $this->endBody() ?>
        
    </body>
</html>
<?php $this->endPage() ?>
