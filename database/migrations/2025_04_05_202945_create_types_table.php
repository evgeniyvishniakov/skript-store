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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название типа (на английском)
            $table->string('label'); // Отображаемое название (на русском)
            $table->string('scope'); // 'category', 'product' или 'universal'
            $table->string('color')->default('#6e3aff'); // Цвет для визуализации
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
