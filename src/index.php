<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use GuzzleHttp\Psr7\LazyOpenStream;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $newStream = new LazyOpenStream('index.html', 'r');
    $newResponse = $response->withBody($newStream);
    return $newResponse;
});

$app->get('/game', function (Request $request, Response $response, $args) {
    $newStream = new LazyOpenStream('game.html', 'r');
    $newResponse = $response->withBody($newStream);
    return $newResponse;
});

$app->run();