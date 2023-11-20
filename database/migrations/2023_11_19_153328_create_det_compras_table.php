<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_compras', function (Blueprint $table) {
            $table->id();
            $table->decimal('precioUnit',8,2);
            $table->decimal('precioVenta',8,2);
            $table->integer('descuento');
            $table->string('descripcion',150);
            $table->string('product_id',150);
            $table->integer('compra_id');
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
        Schema::dropIfExists('det_compras');
    }
}
