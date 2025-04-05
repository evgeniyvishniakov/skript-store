<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            // Категории
            ['name' => 'framework', 'label' => 'Фреймворк', 'scope' => 'category', 'color' => '#3b82f6'],
            ['name' => 'language', 'label' => 'Язык', 'scope' => 'category', 'color' => '#10b981'],
            ['name' => 'tool', 'label' => 'Инструмент', 'scope' => 'category', 'color' => '#f59e0b'],

            // Товары
            ['name' => 'script', 'label' => 'Скрипт', 'scope' => 'product', 'color' => '#8b5cf6'],
            ['name' => 'plugin', 'label' => 'Плагин', 'scope' => 'product', 'color' => '#ec4899'],
            ['name' => 'theme', 'label' => 'Тема', 'scope' => 'product', 'color' => '#6366f1'],

            // Универсальные
            ['name' => 'other', 'label' => 'Другое', 'scope' => 'universal', 'color' => '#64748b'],
        ];

        foreach ($types as $type) {
            Type::firstOrCreate(
                ['name' => $type['name'], 'scope' => $type['scope']],
                $type
            );
        }
    }
}
