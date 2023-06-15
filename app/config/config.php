<?php
$path = 'http://';
if (isset($_SERVER['HTTPS']))$path = 'https://';

$url = $path . $_SERVER['SERVER_NAME'].':6010/public';
$url_api ='http://localhost/eng/backend/public/default/api';
define('base_url', $url);
define('base_api', $url_api);
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', 'skyhwk12');
// define('DB_NAME', 'gps');
