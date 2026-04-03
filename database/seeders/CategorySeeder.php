<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['categoryName' => 'Pipa', 'minFlowRate' => 10, 'maxFlowRate' => 100],
            ['categoryName' => 'Valve', 'minFlowRate' => 5, 'maxFlowRate' => 50],
            ['categoryName' => 'Fitting', 'minFlowRate' => 2, 'maxFlowRate' => 20],
            ['categoryName' => 'Lainnya', 'minFlowRate' => 1, 'maxFlowRate' => 10],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
