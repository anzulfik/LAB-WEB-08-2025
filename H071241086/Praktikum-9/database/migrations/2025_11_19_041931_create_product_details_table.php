<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique();
            $table->text('description')->nullable();
            $table->decimal('weight', 8, 2);
            $table->string('size', 255)->nullable();
            $table->timestamps();

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_details');
    }
};
