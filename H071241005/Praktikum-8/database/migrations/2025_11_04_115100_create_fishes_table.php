<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fishes', function (Blueprint $table) {
            $table->bigIncrements('id'); // PRIMARY KEY, BIGINT UNSIGNED, AUTO_INCREMENT
            $table->string('name', 100); // NOT NULL
            $table->enum('rarity', [ // NOT NULL
                'Common', 
                'Uncommon', 
                'Rare', 
                'Epic', 
                'Legendary', 
                'Mythic', 
                'Secret'
            ]);
            $table->decimal('base_weight_min', 8, 2); // NOT NULL
            $table->decimal('base_weight_max', 8, 2); // NOT NULL
            $table->integer('sell_price_per_kg'); // NOT NULL
            $table->decimal('catch_probability', 5, 2); // NOT NULL (e.g., 5.25%)
            $table->text('description')->nullable(); // NULLABLE
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fishes');
    }
};