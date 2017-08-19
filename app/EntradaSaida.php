<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntradaSaida extends Model
{
  protected $table = 'entradaSaida';
  protected $fillable = ['id', 'idUser', 'local', 'data', 'valor', 'tipo', 'created_at', 'updated_at'];
}