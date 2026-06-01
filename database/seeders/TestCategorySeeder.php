<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestCategory;
use App\Models\DiagnosticService;

class TestCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hematology', 'slug' => 'hematology', 'type' => 'laboratory', 'description' => 'Blood related tests including CBC, Hb%, ESR'],
            ['name' => 'Biochemistry', 'slug' => 'biochemistry', 'type' => 'laboratory', 'description' => 'Blood sugar, lipid profile, liver function, kidney function'],
            ['name' => 'Microbiology', 'slug' => 'microbiology', 'type' => 'laboratory', 'description' => 'Urine R/E, Stool R/E, Culture & Sensitivity'],
            ['name' => 'Serology', 'slug' => 'serology', 'type' => 'laboratory', 'description' => 'Hormone tests, Thyroid profile, Vitamin assays'],
            ['name' => 'Immunology', 'slug' => 'immunology', 'type' => 'laboratory', 'description' => 'Allergy tests, Autoimmune markers'],
            ['name' => 'X-Ray', 'slug' => 'x-ray', 'type' => 'imaging', 'description' => 'Digital X-Ray services'],
            ['name' => 'Ultrasound', 'slug' => 'ultrasound', 'type' => 'imaging', 'description' => 'USG of whole abdomen, pelvis, etc.'],
            ['name' => 'Cardiology', 'slug' => 'cardiology', 'type' => 'cardiology', 'description' => 'ECG, Echo, Stress Test'],
            ['name' => 'CT Scan', 'slug' => 'ct-scan', 'type' => 'imaging', 'description' => 'CT scan services'],
            ['name' => 'MRI', 'slug' => 'mri', 'type' => 'imaging', 'description' => 'MRI diagnostic services'],
        ];

        foreach ($categories as $category) {
            TestCategory::create($category);
        }
    }
}