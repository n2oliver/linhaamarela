<?php
namespace Web;
use App\Controllers\HomeController;
use App\Controllers\UsuarioInscricaoController;
use App\Controllers\UsuarioLoginController;
use App\Controllers\ScoreController;

class Routes {
    public function run($app) {
        $app->get('/', [HomeController::class, 'inicio']);
        $app->post('/inscricao', [UsuarioInscricaoController::class, 'postInscricao']);
        $app->post('/login', [UsuarioLoginController::class, 'postLogin']);
        $app->post('/registrar-pontos', [ScoreController::class, 'handle']);
        return $app;
    }
}