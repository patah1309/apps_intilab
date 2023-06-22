<?php
$path = 'http://';
if (isset($_SERVER['HTTPS']))$path = 'https://';

$url = $path . $_SERVER['SERVER_NAME'].':8080/public';
$url_api ='https://apps.intilab.com/eng/backend/public/default/api';
// $url_api ='http://localhost/eng/backend/public/default/api';
$url_foto ='http://localhost/eng/backend/public/dokumentasi/';
define('base_url', $url);
define('base_api', $url_api);
define('base_foto', $url_foto);
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', 'skyhwk12');
// define('DB_NAME', 'gps');