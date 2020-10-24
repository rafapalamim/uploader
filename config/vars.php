<?php

// DEFAULT
define('APPPATH', realpath(dirname(__DIR__)));
define('ENV', 'production');

// UPLOADER CONSTANTS
define('DEFAULT_STORAGE', 'local');
define('DEFAULT_LOG_FORMAT', 'file');

define('UPLOADER_CONF', [
    'generate_log' => (ENV == 'production' ? true : false),
    'generate_thumbs' => (ENV == 'production' ? true : true),
    'thumbs' => [
        '500x300' => [500, 300],
        '300x120' => [300, 120],
        '250x80' => [250, 80],
        '500' => [500, 0],
        '300' => [300, 0],
        '250' => [250, 0]
    ]
]);

define('UPLOADER_STORAGES', [
    'local' => [
        'name_local' => 'local',
        'auth_login_local' => '',
        'auth_passw_local' => '',
        'auth_token_local' => '',
        'initial_path' => ''
    ],
    'aws_bucket' => [
        'name_local' => 'aws_bucket',
        'auth_login_local' => '',
        'auth_passw_local' => '',
        'auth_token_local' => '',
        'initial_path' => ''
    ],
    'google_drive' => [
        'name_local' => 'google_drive',
        'auth_login_local' => '',
        'auth_passw_local' => '',
        'auth_token_local' => '',
        'initial_path' => ''
    ]
]);
