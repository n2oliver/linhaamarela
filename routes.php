<?php
namespace App;
use App\Controllers\HomeController;
use App\Controllers\UsuarioInscricaoController;
use App\Controllers\UsuarioLoginController;

class Routes {
    public function run($app) {
        $app->get('/', [HomeController::class, 'inicio']);
        $app->post('/inscricao', [UsuarioInscricaoController::class, 'postInscricao']);
        $app->post('/login', [UsuarioLoginController::class, 'postLogin']);
        return $app;
    }
}