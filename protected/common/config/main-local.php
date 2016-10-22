<?php
if(YII_ENV == 'test' || YII_ENV == 'local-test')
{
    $selectedDsn = $functionalTestDsn; 
}
else
{
    $selectedDsn = $dsn;
}
$config = [
    'components' => [
        'db' => [
            'dsn'           => $selectedDsn,
            'username'      => $username,
            'password'      => $password,
            'charset'       => 'utf-8',
            'emulatePrepare'=> true,
            'tablePrefix'   => 'tbl_',
            'schemaCache' => 'cache'
        ],
        'mailer' => [
            'class' => 'usni\library\mailers\UiSwiftMailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ]
];

if (YII_ENV_DEV && YII_DEBUG)
{
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
                                    'class' => 'yii\gii\Module'
                                ];
}

return $config;