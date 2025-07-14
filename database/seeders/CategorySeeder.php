<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tacos',
                'description' => 'Tortillas de milho ou trigo recheadas com diversos ingredientes tradicionais mexicanos',
                'image_url' => '/images/categories/tacos.jpg'
            ],
            [
                'name' => 'Burritos',
                'description' => 'Tortillas de trigo grandes recheadas e enroladas com feijão, arroz, carne e vegetais',
                'image_url' => '/images/categories/burritos.jpg'
            ],
            [
                'name' => 'Quesadillas',
                'description' => 'Tortillas dobradas e grelhadas recheadas com queijo derretido e outros ingredientes',
                'image_url' => '/images/categories/quesadillas.jpg'
            ],
            [
                'name' => 'Nachos',
                'description' => 'Tortilla chips crocantes cobertos com queijo derretido, jalapeños e molhos',
                'image_url' => '/images/categories/nachos.jpg'
            ],
            [
                'name' => 'Bebidas',
                'description' => 'Refrescos tradicionais mexicanos, águas frescas e bebidas geladas',
                'image_url' => '/images/categories/bebidas.jpg'
            ],
            [
                'name' => 'Sobremesas',
                'description' => 'Doces e sobremesas tradicionais mexicanas como churros e flan',
                'image_url' => '/images/categories/sobremesas.jpg'
            ],
            [
                'name' => 'Entradas',
                'description' => 'Aperitivos e entradas para começar sua refeição mexicana',
                'image_url' => '/images/categories/entradas.jpg'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
