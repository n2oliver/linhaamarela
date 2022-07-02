<?php
namespace App\Repository;

use App\Models\Login;

class LoginRepository {
    public function insert($attributes) {    
        return Login::create(
            array(
                'usuario_id' => $attributes['usuario_id'],
                'expira_em' => $attributes['data_expiracao'],
                'codigo_login' => $attributes['hash'],
            )
        );
    }
}