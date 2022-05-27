<?php
namespace Db\Eloquent\Models;
 
use \Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $fillable = [
        'nomedeusuario', // Nome
        'email', // Email
        'nome', // Primeiro
        'sobrenome', // Sobrenome
        'nascimento', // Data de nascimento
        'senha' // Senha criptografada do usuário
    ];
}