<?php
namespace Web;
use App\Controllers\HomeController;
use App\Controllers\DemoController;
use App\Controllers\UsuarioInscricaoController;
use App\Controllers\UsuarioLoginController;
use App\Controllers\ScoreController;

class Routes {
    public function run($app) {
        $app->get('/linhaamarela', [HomeController::class, 'inicio']);
        $app->get('/linhaamarela/', [HomeController::class, 'inicio']);
        $app->get('/linhaamarela/login', [HomeController::class, 'login']);
        $app->get('/linhaamarela/login/', [HomeController::class, 'login']);
        $app->post('/linhaamarela/inscricao', [UsuarioInscricaoController::class, 'postInscricao']);
        $app->post('/linhaamarela/inscricao/', [UsuarioInscricaoController::class, 'postInscricao']);
        $app->post('/linhaamarela/login', [UsuarioLoginController::class, 'postLogin']);
        $app->post('/linhaamarela/login/', [UsuarioLoginController::class, 'postLogin']);
        $app->post('/linhaamarela/registrar-pontos', [ScoreController::class, 'postScores']);
        $app->post('/linhaamarela/registrar-pontos/', [ScoreController::class, 'postScores']);
        $app->get('/linhaamarela/obter-pontos', [ScoreController::class, 'getScores']);
        $app->get('/linhaamarela/obter-pontos/', [ScoreController::class, 'getScores']);
        $app->get('/linhaamarela/demo', [DemoController::class, 'inicio']);
        $app->get('/linhaamarela/demo/', [DemoController::class, 'inicio']);
        return $app;
    }
}