<?php
namespace App\Repository;

use Db\Eloquent\Models\Usuario;

class UsuarioRepository {
    public function insert($attributes) {    
        return Usuario::create(
            array(
                'nomedeusuario' => $attributes['nomedeusuario-inscricao'],
                'email' => $attributes['email-inscricao'],
                'senha' => $attributes['senha-inscricao'],
            )
        );
    }
    public function find($attributes) {    
        return Usuario::leftJoin('login as l', 
            function($join) {
                $join->on('usuario.id', '=', 'l.usuario_id');
            })
            ->select(array('usuario.id', 'l.id'))
            ->where('nomedeusuario', '=', $attributes['nomedeusuario'])
            ->where('senha', '=', md5($attributes['senha']))
            ->orderBy('usuario.id')
            ->first();
    }
}