<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_warehouse', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->cascadeOnDelete();

            $table->foreign('warehouse_id')
                  ->references('id')
                  ->on('warehouses')
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_warehouse');
    }
};
