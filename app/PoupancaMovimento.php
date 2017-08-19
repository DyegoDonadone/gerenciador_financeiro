<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoupancaMovimento extends Model
{

  protected $table = 'movimento_poupanca';
  protected $fillable = ['id', 'idUser', 'data', 'tipo', 'valor', 'idPoupanca', 'created_at', 'updated_at'];
}
