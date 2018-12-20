<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'YNpP1ZGL1fgV7kh0EeXwI4MEpEGzw37_',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=fotainstance.cwhqnqtmrtqa.us-east-2.rds.amazonaws.com;dbname=HiFota',
            'username' => 'fotaadmin',
            'password' => 'fotaadmin@123',
            'charset' => 'utf8',
        ],
    ],
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['183.62.194.98', '::1'], 
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['183.62.194.98', '::1'], 
    ];
}

return $config;
