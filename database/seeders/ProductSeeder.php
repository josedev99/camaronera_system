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
            'name' => 'Lubricante de auto',
            'barcode' => '525222',
            'cost' => '20',
            'pricev' => '30',
            'stock' => '10',
            'alerts' => '5',
            'percentage' => '5',
            'image' => 'noimg.png',
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Espuma 210',
            'barcode' => '5251222',
            'cost' => '20',
            'pricev' => '30',
            'stock' => '10',
            'alerts' => '5',
            'percentage' => '5',
            'image' => 'noimg.png',
            'category_id' => 2,
        ]);
        Product::create([
            'name' => 'Volante',
            'barcode' => '525222',
            'cost' => '20',
            'pricev' => '30',
            'stock' => '10',
            'alerts' => '5',
            'percentage' => '5',
            'image' => 'noimg.png',
            'category_id' => 3,
        ]);
    }
}
