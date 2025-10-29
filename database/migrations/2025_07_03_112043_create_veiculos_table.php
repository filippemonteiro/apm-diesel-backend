<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->string('cor');
            $table->decimal('km')->default(0);

            $table->string('placa', 10)->after('id')->unique();
            $table->year('ano')->after('placa');

            $table->text('observacao')->nullable();
            $table->text('observacoes')->nullable();

            $table->string('combustivel')->nullable()->after('observacoes');
            $table->string('status')->default('disponivel')->after('combustivel');
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
        Schema::dropIfExists('veiculos');
    }
}