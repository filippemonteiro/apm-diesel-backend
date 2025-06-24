<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosRotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_rotas', function (Blueprint $table) {
            $table->id();
            $table->string('hora_inicio');
            $table->string('hora_fim');
            $table->string('descricao')->nullable();

            $table->unsignedBigInteger('rota_id');
            $table->foreign('rota_id')->references('id')->on('rotas');
            
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
        Schema::dropIfExists('horarios_rotas');
    }
}
