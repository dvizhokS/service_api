<?php

date_default_timezone_set("Europe/Kiev");
error_reporting(0);

$config_effects = [
    'smtp' => [
        'host' => 'smtp.ukr.net',
        'port' => '2525',
        'protocol' => 'ssl',
        'login' => 'postname@ukr.net',
        'password' => 'password',
        'name' => 'Name SecondName',
        'fromEmail' => 'postname@ukr.net',
        'toEmail' => 'toPostname@email.ua',
        'templates' => [
            0,
            ["subject"=>"Project-1 name %name%",
            "message"=>"Project-1 name: %name%\n Project description: %description%"],
            ["subject"=>"Project-2 name - %name%, This second template",
            "message"=>"Project-2 name: %name%\n Project description: %description%"]
        ]
        ],
    'telegram' =>[
        'token' => 'bot_token',
        'chat_id' => '@ChannelName',
        'templates' => [
            0,
            ["message"=>"Project-1, id = %id%, name: %name%"],
            ["message"=>"Project-2, id = %id%, name: %name%"]
        ]

    ],
];