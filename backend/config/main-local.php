<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'YNpP1ZGL1fgV7kh0EeXwI4MEpEGzw37_',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=HiFota',
            'username' => 'fotaadmin',
            'password' => 'fotaadmin@123',
            'charset' => 'utf8',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
