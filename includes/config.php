<?php

/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/
define('DB_HOST', 'localhost');
define('DB_NAME', 'klinikcms');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');


/*
|--------------------------------------------------------------------------
| SITE URL
|--------------------------------------------------------------------------
| Lokal:
| http://localhost/klinikcms
|
| Production örnek:
| https://senindomain.com
|--------------------------------------------------------------------------
*/
define('SITE_URL', 'http://localhost/klinikcms');


/*
|--------------------------------------------------------------------------
| PATHS
|--------------------------------------------------------------------------
*/
define('BASE_PATH', dirname(__DIR__));

define('UPLOAD_PATH', BASE_PATH . '/uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads/');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
define('ADMIN_SESSION_NAME', 'klinik_admin');


/*
|--------------------------------------------------------------------------
| HELPER URL FUNCTIONS
|--------------------------------------------------------------------------
*/

function site_url(string $path = ''): string
{
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}

function api_url(string $path = ''): string
{
    return site_url('api/' . ltrim($path, '/'));
}

function upload_url(string $path = ''): string
{
    return rtrim(UPLOAD_URL, '/') . '/' . ltrim($path, '/');
}

function asset_url(string $path = ''): string
{
    return site_url(ltrim($path, '/'));
}