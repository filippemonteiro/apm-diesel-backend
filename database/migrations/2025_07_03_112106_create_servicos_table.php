<?php

class CreateServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // Campo como string conforme especificação
            $table->date('data');
            $table->time('hora');
            $table->text('observacao')->nullable();
            $table->integer('km')->default(0);
            $table->decimal('valor', 10, 2)->default(0);
            $table->unsignedBigInteger('motorista_id');
            $table->unsignedBigInteger('veiculo_id');
            $table->timestamps();

            $table->foreign('motorista_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('veiculo_id')->references('id')->on('veiculos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicos');
    }
}