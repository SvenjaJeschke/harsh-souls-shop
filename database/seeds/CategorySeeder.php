<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'display_name' => 'Bondage',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Toys',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Lingerie',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Body Pillows',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Extras',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Dildos',
                'parent_id' => 2,
                'is_active' => true
            ],
            [
                'display_name' => 'Vibrators',
                'parent_id' => 2,
                'is_active' => true
            ],
            [
                'display_name' => 'Partner Toys',
                'parent_id' => 2,
                'is_active' => true
            ],
            [
                'display_name' => 'Condoms',
                'parent_id' => 5,
                'is_active' => true
            ],
            [
                'display_name' => 'Energy Drinks',
                'parent_id' => 5,
                'is_active' => true
            ],
            [
                'display_name' => 'Other',
                'parent_id' => 5,
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
