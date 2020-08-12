<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(Product::class, 69)->create()->make();

        $products = [
            ['display_name' => '24k Gold Plated Cuffs', 'description' => null, 'price' => 3300.00, 'is_active' => true],
            ['display_name' => 'Adjustable Harness', 'description' => null, 'price' => 500.00, 'is_active' => true],
            ['display_name' => 'Plush Cuffs', 'description' => null, 'price' => 300.00, 'is_active' => true],
            ['display_name' => '18k Gold Body Chain', 'description' => null, 'price' => null, 'is_active' => true],
            ['display_name' => 'Chastity Panties', 'description' => null, 'price' => null, 'is_active' => true],
            ['display_name' => 'Fishnet Pantyhose', 'description' => null, 'price' => null, 'is_active' => true],
            ['display_name' => 'Dildo With Balls', 'description' => null, 'price' => 250.00, 'is_active' => true],
            ['display_name' => 'Dildo With Suction Cup', 'description' => null, 'price' => 250.00, 'is_active' => true],
            ['display_name' => 'Penis Copy Kit', 'description' => null, 'price' => 250.00, 'is_active' => true],
            ['display_name' => 'Glass Dildo Beads', 'description' => null, 'price' => 350.00, 'is_active' => true],
            ['display_name' => 'Glass Dildo Candy Cane', 'description' => null, 'price' => 350.00, 'is_active' => true],
            ['display_name' => 'Glass Dildo Hearts', 'description' => null, 'price' => 350.00, 'is_active' => true],
            ['display_name' => 'Big Dick Energy Drink', 'description' => null, 'price' => 50.00, 'is_active' => true],
            ['display_name' => 'Condoms Normal 100 Pieces', 'description' => 'Unit price 35$', 'price' => 3000.00, 'is_active' => true],
            ['display_name' => 'Double Sided Dildo', 'description' => null, 'price' => 380.00, 'is_active' => true],
            ['display_name' => 'Latex Panties With Strapon', 'description' => null, 'price' => 430.00, 'is_active' => true],
            ['display_name' => 'Strapon Harness', 'description' => null, 'price' => 430.00, 'is_active' => true],
            ['display_name' => '14k Gold Coating Vibrator', 'description' => null, 'price' => 3320.00, 'is_active' => true],
            ['display_name' => 'Dorr Aura G Spot', 'description' => null, 'price' => 320.00, 'is_active' => true],
            ['display_name' => 'G Spot Vibrator', 'description' => null, 'price' => 320.00, 'is_active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
