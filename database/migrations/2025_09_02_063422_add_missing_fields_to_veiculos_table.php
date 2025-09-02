<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->string('qrCode')->unique()->after('status');
            $table->integer('odometer')->default(0)->after('qrCode'); // quilometragem atual
            $table->integer('fuelLevel')->default(100)->after('odometer'); // nível de combustível
            $table->foreignId('currentUserId')->nullable()->constrained('users')->onDelete('set null')->after('fuelLevel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropForeign(['currentUserId']);
            $table->dropColumn(['qrCode', 'odometer', 'fuelLevel', 'currentUserId']);
        });
    }
}
