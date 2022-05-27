<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Validators\UsuarioValidator;
use App\UseCases\UsuarioInscreverUseCase;

class UsuarioInscricaoController {
    private $inscreverUsuario;
    
    public function __construct(?UsuarioInscreverUseCase $usuarioInscreverUseCase) {
        $this->inscreverUsuario = $usuarioInscreverUseCase ?? new UsuarioInscreverUseCase();
    }
    public function postInscricao (Request $request, Response $response) {
        $usuarioValidator = new UsuarioValidator();
        $formData = $request->getParsedBody();
        if($validacao = $usuarioValidator->postValidarInscricao($response, $formData)) {
            return $validacao;
        }
        $formData['senha-inscricao'] = md5($formData['senha-inscricao']);
        $insertion = $this->inscreverUsuario->execute($formData);
        
        $payload = json_encode(
            array(
                'message' => 'Sucesso!', 
                'code' => 200, 
                'body' => array(
                    'insertion' => array(
                        'id' => $insertion->id
                    )
                )
            )
        );
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}