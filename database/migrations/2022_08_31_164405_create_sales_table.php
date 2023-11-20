<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10,2);
            $table->string('customer', 150);
            $table->string('image')->nullable();
            $table->decimal('grams', 10,2);
            $table->string('pond', 50);
            $table->string('invoice', 50);
            $table->string('type_invoice', 50);
            $table->integer('items');
            $table->decimal('iva', 10,2);
            $table->enum('pay', ['CONTADO', 'CREDITO'])->default('CONTADO');
            $table->enum('status', ['PAID', 'PENDING', 'CANCELLED'])->default('PAID');
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            
            
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
        Schema::dropIfExists('sales');
    }
}
