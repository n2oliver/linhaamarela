<?php
namespace App\Repository;

use App\Models\Usuario;
use Illuminate\Database\Capsule\Manager as DB;

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
            ->select(array('usuario.id', 'l.id as login_id', 'usuario.nomedeusuario'))
            ->where('nomedeusuario', '=', $attributes['nomedeusuario'])
            ->where('senha', '=', md5($attributes['senha']))
            ->orderBy('usuario.id')
            ->first();
    }
    public function getHighScores($page, $limit) {
        return DB::select('SELECT * FROM recordes
                            JOIN usuario 
                            ON usuario.id = usuario_id 
                                ORDER BY pontuacao DESC LIMIT :page, :limit', [$page, $limit]);
    }
    public function getTotalHighScores() {
        return DB::select('SELECT COUNT(*) as total FROM recordes JOIN usuario ON usuario.id = usuario_id ORDER BY pontuacao DESC');
    }
    public function getPreviousHighScore($userId, $userPoints) {
        return DB::select('SELECT * FROM recordes WHERE usuario_id = :userId AND pontuacao > :userPoints', [$userId, $userPoints]);
    }
    public function getCurrentHighScore($userId) {
        return DB::select('SELECT * FROM (SELECT pontuacao, ROW_NUMBER() OVER () AS posicao, usuario_id FROM recordes ORDER BY pontuacao DESC) as c WHERE c.usuario_id = :userId', [$userId]);
    }
    public function setHighScore($userId, $userPoints) {
        return DB::insert('REPLACE INTO recordes (usuario_id, pontuacao) VALUES (:userId, :userPoints)', [$userId, $userPoints]);
    }
}