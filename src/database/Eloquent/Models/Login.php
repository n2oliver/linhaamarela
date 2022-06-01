<?php
namespace Db\Eloquent\Models;
 
use \Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'login';

    protected $primaryKey = 'id';
    protected $fillable = [
        'usuario_id', // Id do usuário
        'created_at', // Data de criação
        'updated_at', // Data de atualização
        'expira_em', // Data de expiração
        'codigo_login', // Token
    ];
}