<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use GuzzleHttp\Psr7\LazyOpenStream;
use Db\Eloquent\Models\Usuario;
use \Illuminate\Database\Capsule\Manager;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$container = $app->getContainer();
$capsule = new Manager;

require __DIR__ . '/config/database.php';

$app->get('/', function (Request $request, Response $response, $args) {
    $newStream = new LazyOpenStream('index.html', 'r');
    $newResponse = $response->withBody($newStream);
    return $newResponse;
});

$app->get('/login', function (Request $request, Response $response, $args) {
    $usuarios = Usuario::get();
    
    $payload = json_encode($usuarios);
    $response->getBody()->write($payload);

    return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
});
$app->run();