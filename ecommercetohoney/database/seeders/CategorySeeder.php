<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $demo_categories = [
            'Honey',
            'Natural Oil',
            'Nuts',
            'Coconut',
            'Butter',
        ];

        foreach ($demo_categories as $value) {
            Category::create([
                'title' => $value,
                'slug' => Str::slug($value),
            ]);
        }
    }
}
