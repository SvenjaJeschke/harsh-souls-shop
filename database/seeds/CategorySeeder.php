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
                'display_name' => 'Toys',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Accessories',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Clothing',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                'display_name' => 'Male',
                'parent_id' => 3,
                'is_active' => true
            ],
            [
                'display_name' => 'Female',
                'parent_id' => 3,
                'is_active' => true
            ],
            [
                'display_name' => 'Innocent stuff',
                'parent_id' => 1,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
