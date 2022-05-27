<?php
namespace App\Repository;

use Db\Eloquent\Models\Usuario;

class UsuarioRepository {
    public function insert($attributes) {    
        Usuario::create(
            array(
                'nomedeusuario' => $attributes['nome-inscricao'],
                'email' => $attributes['email-inscricao'],
                'senha' => $attributes['senha-inscricao'],
            )
        );
    }
}