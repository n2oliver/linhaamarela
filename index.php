<?php
error_log(__DIR__ . '/vendor/autoload.php');
require __DIR__ . '/vendor/autoload.php';
use App\App;

$app = new App;
$app->run();