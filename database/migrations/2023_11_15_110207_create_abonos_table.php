<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recibo', 150);
            $table->string('tipo_pago', 50);
            $table->decimal('monto_abono', 10,2);
            $table->decimal('saldo', 10,2);
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('abonos');
    }
}
