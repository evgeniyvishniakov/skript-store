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
            // Добавляем столбец как внешний ключ
            $table->unsignedBigInteger('type_id')->after('name');

            // Если таблица types существует, добавляем связь
            if (Schema::hasTable('types')) {
                $table->foreign('type_id')->references('id')->on('types');
            }
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Удаляем внешний ключ сначала
            $table->dropForeign(['type_id']);
            // Затем удаляем сам столбец
            $table->dropColumn('type_id');
        });
    }
};
