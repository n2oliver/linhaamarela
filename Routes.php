<?php
namespace Web;
use App\Controllers\HomeController;
use App\Controllers\DemoController;
use App\Controllers\UsuarioInscricaoController;
use App\Controllers\UsuarioLoginController;
use App\Controllers\ScoreController;

class Routes {
    public function run($app) {
        $app->get('/', [HomeController::class, 'inicio']);
        $app->get('/login', [HomeController::class, 'login']);
        $app->post('/inscricao', [UsuarioInscricaoController::class, 'postInscricao']);
        $app->post('/login', [UsuarioLoginController::class, 'postLogin']);
        $app->post('/registrar-pontos', [ScoreController::class, 'postScores']);
        $app->get('/obter-pontos', [ScoreController::class, 'getScores']);
        $app->get('/demo', [DemoController::class, 'inicio']);
        return $app;
    }
}