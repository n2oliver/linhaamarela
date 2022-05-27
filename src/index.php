<?php

require __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use GuzzleHttp\Psr7\LazyOpenStream;
use Db\Eloquent\Models\Usuario;
use \Illuminate\Database\Capsule\Manager;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use App\Controllers\UsuarioController;

$app = AppFactory::create();
$container = $app->getContainer();
$capsule = new Manager;
require __DIR__ . '/config/database.php';

$app->get('/', function (Request $request, Response $response, $args) {
    $newStream = new LazyOpenStream('index.html', 'r');
    $newResponse = $response->withBody($newStream);
    return $newResponse;
});
$app->post('/inscricao', function (Request $request, Response $response, $args) {
    $usuarioController = new UsuarioController();
    return $usuarioController->postInscricao($request, $response, $formData);
});
/**  TODO Login
$app->post('/login', function (Request $request, Response $response, $args) {
    
    $formData = $request->getParsedBody();
    $usuarios = Usuario::where('nomedeusuario', '=', $formData['nomedeusuario'])->where('senha', '=', $formData['senha'])->get();
    
    $payload = json_encode($usuarios);
    $response->getBody()->write($payload);
    echo '<pre>' . JWT::encode(array('nome'=> 'OK', 'senha' => '123456', 'token' => 'asdokasdkpasokdaspodkpaskdpk'), 'minha_chave_secreta', 'HS256'). "<br><pre>";
    return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
}); **/
$app->run();