<?php

return [
    'mail' => [
        'gmail' => [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => '',
            'password' => '',
            'from' => [
                'address' => '',
                'name' => ''
            ]
        ],

        'sendgrid' => [
            'host' => 'smtp.sendgrid.net',
            'port' => 587,
            'encryption' => 'tls',
            'username' => '',
            'password' => '',
            'from' => [
                'address' => '',
                'name' => ''
            ]
        ],
    ]
];
