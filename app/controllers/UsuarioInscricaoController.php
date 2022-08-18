<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Validators\UsuarioValidator;
use App\UseCases\UsuarioInscreverUseCase;
use App\UseCases\UsuarioEncontrarUseCase;
use App\UseCases\UsuarioLoginUseCase;
use \Firebase\JWT\JWT;

class UsuarioInscricaoController {
    private $inscreverUsuario;
    
    public function __construct() {
        $this->inscreverUsuario = new UsuarioInscreverUseCase();
        $this->encontrarUsuario = new UsuarioEncontrarUseCase();
        $this->logarUsuario = new UsuarioLoginUseCase();
    }
    public function postInscricao (Request $request, Response $response) {
        $usuarioValidator = new UsuarioValidator();
        $formData = $request->getParsedBody();
        if($validacao = $usuarioValidator->postValidarInscricao($response, $formData)) {
            return $validacao;
        }
        $formData['nomedeusuario'] = $formData['nomedeusuario-inscricao'];
        $formData['senha'] = $formData['senha-inscricao'];
        $formData['senha-inscricao'] = md5($formData['senha-inscricao']);
        $insertion = $this->inscreverUsuario->execute($formData);

        $expirationTimestamp = time() + 28800;
        $date = new \DateTime();
        $date->setTimestamp($expirationTimestamp);
        $formData['data_expiracao'] = $date->format('Y-m-d H:i:s');

        $usuario = $this->encontrarUsuario->execute($formData);
        $hash = JWT::encode(array('id'=> $usuario->nomedeusuario, 'senha' => $usuario->senha, 'data_de_expiracao' => $expirationTimestamp), 'wyelow', 'HS256');
        $formData['usuario_id'] = $usuario->id;
        $formData['hash'] = $hash;
        $this->logarUsuario->execute($formData);

        setcookie('session', $hash, $expirationTimestamp);
        $usuario->_token = $hash;
        $usuario->expiraEm = $expirationTimestamp;

        $payload = json_encode(
            array(
                'message' => 'Sucesso!', 
                'code' => 200, 
                'body' => array(
                    'insertion' => array(
                        'id' => $insertion->id,
                        'usuario' => $usuario
                    )
                )
            )
        );
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}