<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';
    protected $fillable = ['id', 'idUser', 'nome', 'email', 'idade', 'valorRenda', 'created_at', 'updated_at'];
}
