<?php

require __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager;
use App\Controllers\HomeController;
use App\Controllers\UsuarioController;

$app = AppFactory::create();
$container = $app->getContainer();
$capsule = new Manager;
require __DIR__ . '/config/database.php';

$app->get('/', [HomeController::class, 'inicio']);
$app->post('/inscricao', [UsuarioController::class, 'postInscricao']);
/** TODO
 * $app->post('/login', [UsuarioController::class, 'postLogin']);
 * **/
$app->run();