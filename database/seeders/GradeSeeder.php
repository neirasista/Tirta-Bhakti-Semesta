<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            ['gradeName' => 'Grade A', 'minBudget' => 1000000, 'maxBudget' => 5000000],
            ['gradeName' => 'Grade B', 'minBudget' => 500000,  'maxBudget' => 1000000],
            ['gradeName' => 'Grade C', 'minBudget' => 100000,  'maxBudget' => 500000],
        ];

        foreach ($grades as $grade) {
            Grade::create($grade);
        }
    }
}
