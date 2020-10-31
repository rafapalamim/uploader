<?php

// DEFAULT
define('APPPATH', realpath(dirname(__DIR__)));
define('ENV', 'production');
define('SHOW_MORE_INFO_ERRORS', false);

// UPLOADER CONSTANTS
define('UPLOADER_ALLOW_MIMETYPES', [
    'application/pdf',
    'image/jpeg',
    'image/png',
    'image/gif',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]);

define('UPLOADER_MAX_FILESIZE', 1024 * 5); // 5 MB;

define('UPLOADER_DEFAULT_STORAGE', 'local');
define('UPLOADER_DEFAULT_LOG_FORMAT', 'file');

define('UPLOADER_NAME_TABLE_LOG', 'uploader_logs');
define('UPLOADER_NAME_TABLE_FILES', 'uploader_files');

define('UPLOADER_DB', [
    'dsn' => 'mysql:host=db-uploader;dbname=uploader;port=3306;charset=utf8mb4',
    'user' => 'app',
    'pass' => 'app',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
]);

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
        'need_auth' => false,
        'auth_login_local' => '',
        'auth_passw_local' => '',
        'auth_token_local' => '',
        'initial_path' => APPPATH . '/uploader/storage'
    ],
    'aws_bucket' => [
        'name_local' => 'aws_bucket',
        'need_auth' => true,
        'auth_login_local' => '',
        'auth_passw_local' => '',
        'auth_token_local' => '',
        'initial_path' => ''
    ],
    'google_drive' => [
        'name_local' => 'google_drive',
        'need_auth' => true,
        'auth_login_local' => '',
        'auth_passw_local' => '',
        'auth_token_local' => '',
        'initial_path' => ''
    ]
]);
