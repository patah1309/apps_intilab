<?php
$path = 'http://';
if (isset($_SERVER['HTTPS']))$path = 'https://';
$link = 'http://10.88.0.142/eng/backend/public/';
$url = $path . $_SERVER['SERVER_NAME'].':8080/public';
$url_api = $link.'default/api';
$url_foto = $link.'dokumentasi/';
define('base_url', $url);
define('base_api', $url_api);
define('base_foto', $url_foto);
// define('DB_HOST', 'localhost'); 
// define('DB_USER', 'root');
// define('DB_PASS', 'skyhwk12');
// define('DB_NAME', 'gps');