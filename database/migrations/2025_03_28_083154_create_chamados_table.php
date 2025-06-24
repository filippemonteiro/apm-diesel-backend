<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            
            $table->string('status');
            $table->unsignedBigInteger('tipos_chamado_id');
            $table->text('descricao')->nullable();
            $table->text('observacao')->nullable();
            $table->string('path');
            $table->string('prioridade');

            $table->unsignedBigInteger('cidade_id');
            $table->unsignedBigInteger('criado_por');
            $table->unsignedBigInteger('requerido_por')->nullable();

            $table->foreign('tipos_chamado_id')->references('id')->on('tipos_chamados');
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->foreign('criado_por')->references('id')->on('users');
            $table->foreign('requerido_por')->references('id')->on('users');

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
        Schema::dropIfExists('chamados');
    }
}
