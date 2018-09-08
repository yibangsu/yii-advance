<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'test',
            'password' => 'test',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_MailTransport',
                //'host' => 'pop3.263.net',
                //'username' => 'suyibang@hipad.com',
                //'password' => 'syb@201806',
                //'port' => '110',
                //'encryption' => 'none',
            ], 
        ],
    ],
];
