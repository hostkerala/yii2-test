<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,            
            'admins' => ['roopan','roopz'],
            'enableFlashMessages' => false,               
            
        ],
    ],     
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],  
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'enableStrictParsing' => false,
        ],       
    ],
];
