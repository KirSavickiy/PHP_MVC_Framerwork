<?php

$start = microtime(true);

use Kernel\Application;

if (PHP_MAJOR_VERSION < 8){
    die("Require PHP version >= 8.1.0");
}
require_once "../config/config.php";
require_once ROOT . "/vendor/autoload.php";
$app = new Application();
require_once ROOT . "/helpers/helpers.php";
require_once CONFIG . "/routes.php";






$app->run();

app()->router->dispatch();
 $time = microtime(true) - $start;