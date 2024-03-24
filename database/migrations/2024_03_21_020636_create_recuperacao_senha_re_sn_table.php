<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recuperacao_senha_re_sn', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuarios_us')->unsigned();
            $table->foreign('id_usuarios_us')->references('id')->on('usuarios_us');
            $table->string('email');
            $table->integer('token');
            $table->integer('situacao');
            $table->dateTime('data_hora_envio');
            $table->dateTime('data_hora_validade');
            $table->dateTime('data_hora_recuperacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recuperacao_senha_re_sn');
    }
};
