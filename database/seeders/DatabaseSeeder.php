<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use App\Models\Industry;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Industries
        $industries = [
            'Healthcare',
            'Education',
            'Finance',
            'E-commerce',
            'Social Media',
            'Transportation',
            'Entertainment',
            'Real Estate'
        ];
        
        foreach ($industries as $industry) {
            Industry::create(['name' => $industry]);
        }
        
        // Project Types
        $projectTypes = [
            'Web Application',
            'Mobile App',
            'Desktop Application',
            'API Development',
            'Machine Learning',
            'IoT Solution',
            'Blockchain Application'
        ];
        
        foreach ($projectTypes as $type) {
            ProjectType::create(['name' => $type]);
        }
    }
}
