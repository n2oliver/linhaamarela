<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Psr7\LazyOpenStream;
use App\UseCases\UserHighScoreUseCase;

class ScoreController {
    private $highScoreUseCase;
    
    public function __construct() {
        $this->highScoreUseCase = new UserHighScoreUseCase();
    }
    public function handle(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $response->getBody()->write(
            json_encode(
                array(
                    'message' => 'Sucesso!', 
                    'code' => 200, 
                    'body' => array(
                        'insertion' => $this->highScoreUseCase->execute($data['userId'], $data['userPoints'])
                    )
                )
            )
        );
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}