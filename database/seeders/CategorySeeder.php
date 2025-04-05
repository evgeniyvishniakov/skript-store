<?php

namespace Database\Seeders;

use App\Models\admin\Category;
use App\Models\Type;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $frameworkType = Type::where('name', 'framework')->first();
        $toolType = Type::where('name', 'tool')->first();

        $categories = [
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'type_id' => $frameworkType->id,
                'is_active' => true
            ],
            [
                'name' => 'Парсинг данных',
                'slug' => 'parsing',
                'type_id' => $toolType->id,
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
