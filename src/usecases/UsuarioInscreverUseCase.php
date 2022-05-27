<?php
namespace App\UseCases;

use Db\Eloquent\Models\Usuario;

class UsuarioInscreverUseCase {
    public function execute($attributes) {
        Usuario::create(array(
            'nomedeusuario' => $attributes['nome-inscricao'],
            'email' => $attributes['email-inscricao'],
            'senha' => $attributes['senha-inscricao'],
        ));
    }
}