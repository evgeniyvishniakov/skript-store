<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

namespace Database\Seeders;



class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            TypeSeeder::class,
            // Добавьте другие сидеры здесь
            CategorySeeder::class,
        ]);
    }
}
