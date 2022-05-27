<?php
namespace App;
use App\Controllers\HomeController;
use App\Controllers\UsuarioController;

class Routes {
    public function run($app) {
        $app->get('/', [HomeController::class, 'inicio']);
        $app->post('/inscricao', [UsuarioController::class, 'postInscricao']);
        $app->post('/login', [UsuarioController::class, 'postLogin']);
        return $app;
    }
}