<?php
namespace App;
use App\Controllers\HomeController;
use App\Controllers\UsuarioInscricaoController;

class Routes {
    public function run($app) {
        $app->get('/', [HomeController::class, 'inicio']);
        $app->post('/inscricao', [UsuarioInscricaoController::class, 'postInscricao']);
        $app->post('/login', [UsuarioController::class, 'postLogin']);
        return $app;
    }
}