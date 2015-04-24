<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'name'=>'Admin Area',
    'bootstrap' => ['log'],  
    'components' => [        
    'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/frontend/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,                    
            'rules' => [
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
             ],
        ],        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
