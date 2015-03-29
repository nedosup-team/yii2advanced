<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=sakila',
            'username' => 'yii',
            'password' => 'yii',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => base64_decode('bmVkb3NpcC5zbXRwQGdtYWlsLmNvbQ=='),
                'password' => base64_decode('MTIzd3N4Y2Rl'),
                'port' => '587',
                'encryption' => 'tls',
            ],
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
    ],
];
