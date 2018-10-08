<?php
return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => 'suyibang1987@163.com',
                'password' => 'syb1233',
                'port' => '25',
                //'encryption' => 'tls',
            ], 
            'messageConfig' => [  
                'charset' => 'UTF-8',
                'from' => ['suyibang1987@163.com' => 'su']  
            ], 
        ],
    ],
];
