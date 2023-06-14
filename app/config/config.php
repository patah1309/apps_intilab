<?php
$path = 'http://';
if (isset($_SERVER['HTTPS']))$path = 'https://';

$url = $path . $_SERVER['SERVER_NAME'].'/public';
$url_api ='https://apps.intilab.com/eng/backend/';
define('base_url', $url);
define('base_api', $url_api);
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', 'skyhwk12');
// define('DB_NAME', 'gps');
