<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Db\Eloquent\Models\Usuario;
use \Firebase\JWT\JWT;

class UsuarioLoginController {
    public function postLogin(Request $request, Response $response, $args) {
        $formData = $request->getParsedBody();
        $usuarios = Usuario::select("nomedeusuario")->where('nomedeusuario', '=', $formData['nomedeusuario'])->where('senha', '=', md5($formData['senha']))->get();
        
        if($usuarios->count() > 0) {
            $payload = json_encode($usuarios);
            $response->getBody()->write($payload);
            //echo '<pre>' . JWT::encode(array('nome'=> 'OK', 'senha' => '123456', 'token' => 'asdokasdkpasokdaspodkpaskdpk'), 'minha_chave_secreta', 'HS256'). "<br><pre>";
            return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(201);
        }
        $response->getBody()->write("Verifique o nome de usuário ou senha!");
        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
    }
}