<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Validators\UsuarioValidator;

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
}