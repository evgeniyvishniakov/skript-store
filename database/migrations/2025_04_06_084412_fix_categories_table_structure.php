<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Если столбец type больше не нужен
            if (Schema::hasColumn('categories', 'type')) {
                $table->dropColumn('type');
            }

            // Убедимся, что type_id существует и правильно настроен
            if (!Schema::hasColumn('categories', 'type_id')) {
                $table->unsignedBigInteger('type_id')->after('name');
                $table->foreign('type_id')->references('id')->on('types');
            }
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Для отката - восстановим структуру, если нужно
            if (!Schema::hasColumn('categories', 'type')) {
                $table->string('type')->nullable();
            }
        });
    }
};
