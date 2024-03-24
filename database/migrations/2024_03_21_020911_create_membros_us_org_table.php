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
        Schema::create('membros_us_org', function (Blueprint $table) {
            $table->bigInteger('id_usuarios_us')->unsigned();
            $table->bigInteger('id_organizacoes_org')->unsigned();
            $table->primary(['id_organizacoes_org', 'id_usuarios_us']);
            $table->foreign('id_organizacoes_org')->references('id')->on('organizacoes_org');
            $table->foreign('id_usuarios_us')->references('id')->on('usuarios_us');
            $table->text('roles');
            $table->bigInteger('id_usuarios_us_lancamento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membros_us_org');
    }
};
