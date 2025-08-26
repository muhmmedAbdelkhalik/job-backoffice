<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = [
            [
                'name' => 'Technology',
                'description' => 'Software development, IT services, and digital solutions'
            ],
            [
                'name' => 'Healthcare',
                'description' => 'Medical services, pharmaceuticals, and healthcare technology'
            ],
            [
                'name' => 'Finance',
                'description' => 'Banking, insurance, investment, and financial services'
            ],
            [
                'name' => 'Education',
                'description' => 'Schools, universities, online learning, and educational technology'
            ],
            [
                'name' => 'Manufacturing',
                'description' => 'Industrial production, automotive, and consumer goods'
            ],
            [
                'name' => 'Retail',
                'description' => 'E-commerce, brick-and-mortar stores, and consumer goods'
            ],
            [
                'name' => 'Real Estate',
                'description' => 'Property development, sales, and management'
            ],
            [
                'name' => 'Transportation',
                'description' => 'Logistics, shipping, and transportation services'
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Media, gaming, film, and entertainment services'
            ],
            [
                'name' => 'Consulting',
                'description' => 'Business consulting, strategy, and advisory services'
            ]
        ];

        foreach ($industries as $industry) {
            Industry::create($industry);
        }
    }
}
