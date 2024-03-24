<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordRecovery extends Model
{
    use HasFactory;

    protected $table = 'recuperacao_senha_re_sn';

    protected $fillable = [
        'id_usuarios_us',
        'email',
        'token',
        'situacao',
        'data_hora_envio',
        'data_hora_validade',
        'data_hora_recuperacao'
    ];
}
