<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$db_sms = require(__DIR__ . '/db_sms.php');

$config = [
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '1694558864:AAF3PSSRvWlI3iVsdu8_bZDuguCF2ziLnMs',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'db_sms' => $db_sms,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'zmhn042402.onemail.vn',
                'username' => 'thongbao@easycheck.io.vn',
                'password' => 'Thongbao@1234',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
