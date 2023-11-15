<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'nombre' => 'Concentrado inicial',
            'descripcion' => '25%',
            'unidad_medida' => 'GR',
            'image' => 'noimg.png',
            'category_id' => 1,
            'user_id' => 1,
        ]);

        Product::create([
            'nombre' => 'Concentrado final',
            'descripcion' => '15%',
            'unidad_medida' => 'GR',
            'image' => 'noimg.png',
            'category_id' => 1,
            'user_id' => 1,
        ]);
        Product::create([
            'nombre' => 'Test 1',
            'descripcion' => '25%',
            'unidad_medida' => 'GR',
            'image' => 'noimg.png',
            'category_id' => 1,
            'user_id' => 1,
        ]);
    }
}
