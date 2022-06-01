<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Db\Eloquent\Models\Usuario;
use Db\Eloquent\Models\Login;
use \Firebase\JWT\JWT;

class UsuarioLoginController {
    public function postLogin(Request $request, Response $response, $args) {
        $formData = $request->getParsedBody();
        $usuario = Usuario::select("id")->where('nomedeusuario', '=', $formData['nomedeusuario'])->where('senha', '=', md5($formData['senha']))->get()->first();
        
        if($usuario != null) {
            $hash = JWT::encode(array('id'=> $usuario->nomedeusuario, 'senha' => $usuario->senha), 'wyelow', 'HS256');
            
            date_default_timezone_set('America/Sao_Paulo');
            $expirationTimestamp = time() + 28800;
            $date = new \DateTime();
            $date->setTimestamp($expirationTimestamp);
            
            Login::create(
                array(
                    'usuario_id' => $usuario->id,
                    'expira_em' => $date->format('Y-m-d H:i:s'),
                    'codigo_login' => $hash,
                )
            );
            setcookie('session', $hash, $expirationTimestamp);
            
            $payload = json_encode($usuario);
            $response->getBody()->write($payload);
            
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