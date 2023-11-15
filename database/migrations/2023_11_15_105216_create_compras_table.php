<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_proveedor', 150);
            $table->string('descripcion')->nullable();
            $table->decimal('monto', 10,2);
            $table->decimal('saldo', 10,2);
            $table->string('tipo_pago', 150);
            $table->foreignId('product_id')->constrained();
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
        Schema::dropIfExists('compras');
    }
}
