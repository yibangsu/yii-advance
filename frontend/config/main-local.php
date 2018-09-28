<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hdCi3Ov7k3RrS1uekoWOcSSrAsRlp8B1',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=HiFota',
            'username' => 'fotauser',
            'password' => 'fotauser#123',
            'charset' => 'utf8',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['10.1.152.228'], 
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['10.1.152.228'], 
    ];
}

return $config;
