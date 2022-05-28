<?php
namespace App\Validators;

use Psr\Http\Message\ResponseInterface as Response;

class UsuarioValidator {
    public function postValidarInscricao(Response $response, $parameters) {
        if(!$parameters['nomedeusuario-inscricao']) {
            $response->getBody()->write('Informe o nome de usuário!');
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
        if(!$parameters['email-inscricao']) {
            $response->getBody()->write('Informe o email!');
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
        if(!$parameters['senha-inscricao']) {
            $response->getBody()->write('Informe a senha!');
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }
}