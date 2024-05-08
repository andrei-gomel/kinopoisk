<?php

ini_set('display_errors', 1);

error_reporting(E_ALL);

//ini_set('error_reporting', E_ERROR | E_NOTICE | E_PARSE);

use App\Kernel\App;

define('APP_PATH', dirname(__DIR__));

require_once APP_PATH . '/vendor/autoload.php';

$app = new App();

$app->run();
