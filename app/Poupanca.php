<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poupanca extends Model
{
  protected $table = 'poupanca';
  protected $fillable = ['id', 'idUser', 'banco', 'agencia', 'conta', 'saldo', 'created_at', 'updated_at'];
}