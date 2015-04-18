<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
               'modelMap' => 
                [
                    'User' => 'common\models\User',
                ],
            'enableUnconfirmedLogin' => true,            
            'admins' => ['roopan'],
            'enableFlashMessages' => false,               
            
        ],
    ],     
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOpenId',
                    //'clientId' => '180785155645-b0ov8gh9j4mddir33nkdfg0tf2mpmdic.apps.googleusercontent.com',
                    //'clientSecret' => 'A7PdKXSl__XqdZM6AfYNVzmF',                    
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '843361889069040',
                    'clientSecret' => 'b7bb9b24c5ae59a673fb031c4de921e6',
                    'viewOptions' => ['popupWidth' => 800, 'popupHeight' => 500,]  
                ],
            ],
        ],
       
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'enableStrictParsing' => false,
        ],       
    ],
];