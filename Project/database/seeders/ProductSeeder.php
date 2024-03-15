<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'Description of Product 1',
                'image' => 'image1.jpg',
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description of Product 2',
                'image' => 'image2.jpg',
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description of Product 3',
                'image' => 'image3.jpg',
            ],
            [
                'name' => 'Product 4',
                'description' => 'Description of Product 4',
                'image' => 'image4.jpg',
            ],
            [
                'name' => 'Product 5',
                'description' => 'Description of Product 5',
                'image' => 'image5.jpg',
            ],
            [
                'name' => 'Product 6',
                'description' => 'Description of Product 6',
                'image' => 'image6.jpg',
            ],
            [
                'name' => 'Product 7',
                'description' => 'Description of Product 7',
                'image' => 'image7.jpg',
            ],
            [
                'name' => 'Product 8',
                'description' => 'Description of Product 8',
                'image' => 'image8.jpg',
            ],
            [
                'name' => 'Product 9',
                'description' => 'Description of Product 9',
                'image' => 'image9.jpg',
            ],
            [
                'name' => 'Product 10',
                'description' => 'Description of Product 10',
                'image' => 'image10.jpg',
            ],
        ];

        DB::table('products')->insert($products);
    }
}
