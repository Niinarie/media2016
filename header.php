<?php
require_once('config/config.php');
include('password/lib/password.php');

define('SITE_ROOT','/var/www/html/');

session_save_path('/var/www/html');
ini_set('session.gc.probability',1);

session_set_cookie_params (0, SITE_ROOT);
?>