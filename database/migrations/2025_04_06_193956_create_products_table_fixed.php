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
        Schema::create('products', function (Blueprint $table) {
            // ===== Обязательные поля =====
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('slug')->unique()->nullable(false);
            $table->foreignId('type_id')->constrained()->nullable(false);
            $table->decimal('price', 10, 2)->nullable(false);
            $table->foreignId('category_id')->constrained()->nullable(false);
            $table->foreignId('author_id')->constrained('users')->nullable(false);
            $table->boolean('is_active')->default(true)->nullable(false);

            // ===== Необязательные поля =====
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->json('features')->nullable();
            $table->json('pricing_tiers')->nullable();
            $table->string('license')->default('MIT')->nullable();
            $table->string('platform')->nullable();
            $table->json('compatibility')->nullable();
            $table->json('dependencies')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('downloads')->default(0)->nullable();
            $table->integer('sales')->default(0)->nullable();
            $table->float('rating')->default(0)->nullable();
            $table->integer('comments_count')->default(0)->nullable();
            $table->integer('favorites_count')->default(0)->nullable();
            $table->boolean('is_featured')->default(false)->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['type_id', 'platform']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_table_fixed');
    }
};
