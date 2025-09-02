<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // combustivel, manutencao
            $table->date('data');
            $table->time('hora');
            $table->text('observacao')->nullable();
            $table->string('km');
            $table->decimal('valor', 10, 2);
            $table->string('status')->default('AGENDADO'); // AGENDADO, EM_ANDAMENTO, CONCLUIDO, CANCELADO
            $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
            $table->foreignId('motorista_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('service_requests');
    }
}
