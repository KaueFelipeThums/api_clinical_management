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
        Schema::create('organizacoes_org', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuarios_us')->unsigned();
            $table->foreign('id_usuarios_us')->references('id')->on('usuarios_us');
            $table->string('descricao');
            $table->integer('status');
            $table->bigInteger('id_usuarios_us_lancamento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizacoes_org');
    }
};
