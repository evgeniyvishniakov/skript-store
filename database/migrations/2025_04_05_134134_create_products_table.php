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
            // ===== Базовые поля =====
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['script', 'plugin', 'theme', 'library', 'template'])->default('script');

            // ===== Описания =====
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->json('features')->nullable(); // ["Адаптивный дизайн", "Поддержка API"]

            // ===== Цены и лицензия =====
            $table->decimal('price', 10, 2);
            $table->json('pricing_tiers')->nullable(); // {"pro": 99, "enterprise": 199}
            $table->string('license')->default('MIT');

            // ===== Технические данные =====
            $table->string('platform')->nullable(); // Laravel, WordPress, React, etc.
            $table->json('compatibility')->nullable(); // {"php": "8.0+", "laravel": "^9.0"}
            $table->json('dependencies')->nullable(); // Пакеты/библиотеки

            // ===== Медиа =====
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('video_url')->nullable();

            // ===== Статистика =====
            $table->integer('downloads')->default(0);
            $table->integer('sales')->default(0);
            $table->float('rating')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('favorites_count')->default(0);

            // ===== Статусы =====
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();

            // ===== Связи =====
            $table->foreignId('category_id')->constrained();
            $table->foreignId('author_id')->constrained('users');

            $table->timestamps();

            // ===== Индексы =====
            $table->index(['type', 'platform']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
