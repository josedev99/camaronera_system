<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        Category::create([
            'name' => 'Mantenimiento',
            'image' => 'noimg.png'
        ]);
        Category::create([
            'name' => 'Limpieza',
            'image' => 'noimg.png'
        ]);
        Category::create([
            'name' => 'Piezas',
            'image' => 'noimg.png'
        ]);

        Category::create([
            'name' => 'Cultivo',
            'image' => 'noimg.png'
        ]);

        Category::create([
            'name' => 'Otros',
            'image' => 'noimg.png'
        ]);
    }
}
