<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParentIndustry;

class ParentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parent_categories = [
            'Accounting & Banking',
            'Marketing',
            'IT',
            'Engineering',
            'Aviation Sector',
            'BPO/ITES',
            'Logistic',
            'Skill Development',
            'Services',
            'SITC',
            'Food & Procuring',
            'Fresher',
            'E-Goverernance',
            'Hospitality',
            'IT Solutions',
            'Legal',
            'Journalism',
            'Healthcare',
            'Infrastucture',
            'HR Services',
            'Security Services',
            'Telecommunications',
            'Textile Industry',
            'Others'
        ];
        for ($i=0; $i < count($parent_categories); $i++) { 
            ParentIndustry::firstOrCreate([
                'name' => $parent_categories[$i]
            ]);
        }
    }
}
