<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Psr7\LazyOpenStream;
use App\UseCases\UserHighScoreUseCase;
use App\UseCases\HighScoresUseCase;

class ScoreController {
    private $userHighScoreUseCase;
    private $highScoresUseCase;
    
    public function __construct() {
        $this->userHighScoreUseCase = new UserHighScoreUseCase();
        $this->highScoresUseCase = new HighScoresUseCase();
    }
    public function postScores(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $response->getBody()->write(
            json_encode(
                array(
                    'message' => 'Sucesso!', 
                    'code' => 200, 
                    'body' => array(
                        'insertion' => $this->userHighScoreUseCase->execute($data['userId'], $data['userPoints'])
                    )
                )
            )
        );
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
    public function getScores(Request $request, Response $response, $args) {
        $data = $request->getQueryParams();
        $response->getBody()->write(
            json_encode(
                array(
                    'message' => 'Sucesso!', 
                    'code' => 200, 
                    'body' => array(
                        'scores' => $this->highScoresUseCase->execute($data['userId'], $data['page'])
                    )
                )
            )
        );
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}