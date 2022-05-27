<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Validators\UsuarioValidator;
use Db\Eloquent\Models\Usuario;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class UsuarioController {
    public function postInscricao (Request $request, Response $response) {
        $usuarioValidator = new UsuarioValidator();
        $formData = $request->getParsedBody();
        if($validacao = $usuarioValidator->postValidarInscricao($response, $formData)) {
            return $validacao;
        }
        
        $payload = json_encode(array('message' => 'Sucesso!', 'code' => 200));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
    public function postLogin(Request $request, Response $response, $args) {
        $formData = $request->getParsedBody();
        $usuarios = Usuario::where('nomedeusuario', '=', $formData['nomedeusuario'])->where('senha', '=', $formData['senha'])->get();
        
        $payload = json_encode($usuarios);
        $response->getBody()->write($payload);
        echo '<pre>' . JWT::encode(array('nome'=> 'OK', 'senha' => '123456', 'token' => 'asdokasdkpasokdaspodkpaskdpk'), 'minha_chave_secreta', 'HS256'). "<br><pre>";
        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    }
}