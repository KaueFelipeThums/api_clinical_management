<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizacoes_org';

    protected $fillable = [
        'id_usuarios_us',
        'descricao',
        'status',
        'id_usuarios_us_lancamento'
    ];
}
