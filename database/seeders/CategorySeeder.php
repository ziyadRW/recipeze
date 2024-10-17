<?php

namespace Database\Seeders;

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
            ['name' => 'Dairy'],
            ['name' => 'Meat & Poultry'],
            ['name' => 'Seafood'],
            ['name' => 'Fruits'],
            ['name' => 'Vegetables'],
            ['name' => 'Grains & Breads'],
            ['name' => 'Nuts & Seeds'],
            ['name' => 'Spices & Herbs'],
            ['name' => 'Oils & Fats'],
            ['name' => 'Condiments & Sauces'],
            ['name' => 'Sweeteners'],
            ['name' => 'Baking Ingredients'],
            ['name' => 'Legumes & Beans'],
            ['name' => 'Snacks & Sweets'],
            ['name' => 'Beverages'],
            ['name' => 'Processed Foods'],
            ['name' => 'Pasta & Rice'],
            ['name' => 'Dried Goods'],
            ['name' => 'Miscellaneous'],
        ];

        DB::table('categories')->insert($categories);
    }
}
