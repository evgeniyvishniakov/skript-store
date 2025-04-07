<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Удаляем foreign key
            $table->dropForeign(['author_id']);
            // Удаляем столбец
            $table->dropColumn('author_id');
        });
    }
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained('users');
        });
    }
};