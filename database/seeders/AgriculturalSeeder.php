<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\Crop;
use App\Models\PestStrategy;
use Illuminate\Database\Seeder;

class AgriculturalSeeder extends Seeder
{
    public function run()
    {
        // Guides
        Guide::create([
            'title' => 'Organic vegetable farming',
            'category' => 'Spring / Summer',
            'description' => 'Seasonal planting, composting & natural fertilizer.',
            'season' => 'Spring, Summer',
            'method' => 'Organic',
            'steps' => ['Soil preparation', 'Seed selection', 'Planting', 'Maintenance', 'Harvest'],
            'tips' => ['Use compost', 'Rotate crops', 'Water deeply']
        ]);

        Guide::create([
            'title' => 'Grain farming',
            'category' => 'Dryland',
            'description' => 'Wheat, corn, rice: soil prep & irrigation.',
            'season' => 'Year-round',
            'method' => 'Conventional',
            'steps' => ['Land preparation', 'Sowing', 'Irrigation', 'Fertilization', 'Harvest'],
            'tips' => ['Monitor soil moisture', 'Use appropriate fertilizers']
        ]);

        // Crops
        Crop::create([
            'name' => 'Wheat',
            'category' => 'grains',
            'description' => 'Staple grain crop, rich in carbohydrates and protein.',
            'soil_requirements' => 'Loamy, pH 6-7',
            'cultivation_method' => 'Sowing in rows',
            'harvest_time' => '90-120 days',
            'nutritional_value' => 'High in carbs, protein, fiber',
            'uses' => 'Bread, pasta, flour production'
        ]);

        Crop::create([
            'name' => 'Tomato',
            'category' => 'vegetables',
            'description' => 'Versatile fruit vegetable, rich in vitamins.',
            'soil_requirements' => 'Well-drained, pH 6-6.8',
            'cultivation_method' => 'Seedling transplant',
            'harvest_time' => '60-80 days',
            'nutritional_value' => 'Rich in vitamin C, potassium',
            'uses' => 'Fresh consumption, sauces, paste'
        ]);

        // Pest Strategies
        PestStrategy::create([
            'title' => 'Monitoring & Early Detection',
            'type' => 'monitoring',
            'description' => 'Regular scouting and trap crops for early pest identification.',
            'methods' => ['Visual inspection', 'Pheromone traps', 'Sticky traps'],
            'tips' => ['Check crops weekly', 'Keep records', 'Identify beneficial insects']
        ]);

        PestStrategy::create([
            'title' => 'Biological Control',
            'type' => 'biological',
            'description' => 'Using natural predators and beneficial organisms.',
            'methods' => ['Ladybugs', 'Parasitic wasps', 'Nematodes'],
            'tips' => ['Create habitat for beneficials', 'Avoid broad-spectrum pesticides']
        ]);

        PestStrategy::create([
            'title' => 'Organic Remedies',
            'type' => 'organic',
            'description' => 'Natural and organic pest control solutions.',
            'methods' => ['Neem oil', 'Diatomaceous earth', 'Insecticidal soaps'],
            'tips' => ['Apply in evening', 'Test on small area first']
        ]);

        PestStrategy::create([
            'title' => 'Treatment & Management',
            'type' => 'treatment',
            'description' => 'Threshold-based application and rotation strategies.',
            'methods' => ['Chemical application', 'Crop rotation', 'Resistant varieties'],
            'tips' => ['Follow label instructions', 'Rotate modes of action']
        ]);
    }
}
