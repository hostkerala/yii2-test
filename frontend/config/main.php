<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name'=>'Frontend Area',
    'controllerNamespace' => 'frontend\controllers',   
    'components' => [
    'urlManagerBackend' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/backend/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
                    'class' => 'yii\web\UrlManager',
            'rules' => [
                'site/index' => 'site/users',
            ]
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
