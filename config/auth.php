<?php

return [
    "auth.alg" => "HS256",
    "auth.type" => "JWT",
    "auth.tables" => [
        'users' => 'authentication',
        'confirmations' => 'authentication_confirmations',
        'remembered' => 'authentication_remembered',
        'resets' => 'authentication_resets',
        'throttling' => 'authentication_throttling',
        'profile' => 'authentication_users',
    ],
    "auth.profile_session_name" => '_app_authentication',
];
