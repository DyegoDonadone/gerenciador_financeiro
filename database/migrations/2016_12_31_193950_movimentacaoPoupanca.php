<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MovimentacaoPoupanca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('movimento_poupanca', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idUser');
            $table->string('data');
            $table->string('tipo');
            $table->string('valor');
            $table->string('idPoupanca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('movimento_poupanca');
    }
}
