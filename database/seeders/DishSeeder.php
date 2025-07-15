<?php

namespace Database\Seeders;

use App\Enums\SpiceLevel;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('Nenhuma categoria encontrada! Execute CategorySeeder primeiro.');
            return;
        }

        $dishes = [
            'Tacos' => [
                ['name' => 'Taco al Pastor', 'description' => 'Taco com carne de porco marinada, abacaxi, cebola e coentro', 'price' => 12.90, 'ingredients' => ['carne al pastor', 'abacaxi', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => 'Médio'],
                ['name' => 'Taco de Carnitas', 'description' => 'Taco com carne de porco desfiada, cebola e coentro', 'price' => 11.90, 'ingredients' => ['carnitas', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => 'Suave'],
                ['name' => 'Taco de Pollo', 'description' => 'Taco com frango temperado, alface e tomate', 'price' => 10.90, 'ingredients' => ['frango', 'alface', 'tomate', 'tortilla de milho'], 'spice_level' => 'Suave'],
                ['name' => 'Taco de Barbacoa', 'description' => 'Taco com carne bovina cozida lentamente, cebola e coentro', 'price' => 13.90, 'ingredients' => ['barbacoa', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => 'Médio'],
                ['name' => 'Taco de Pescado', 'description' => 'Taco com peixe grelhado, repolho e molho chipotle', 'price' => 14.90, 'ingredients' => ['peixe', 'repolho', 'molho chipotle', 'tortilla de milho'], 'spice_level' => 'Picante'],
                ['name' => 'Taco de Chorizo', 'description' => 'Taco com linguiça mexicana, cebola e pimenta', 'price' => 12.90, 'ingredients' => ['chorizo', 'cebola', 'pimenta jalapeño', 'tortilla de milho'], 'spice_level' => 'Picante'],
                ['name' => 'Taco Vegetariano', 'description' => 'Taco com feijão preto, guacamole e vegetais', 'price' => 9.90, 'ingredients' => ['feijão preto', 'guacamole', 'alface', 'tomate', 'tortilla de milho'], 'spice_level' => 'Suave'],
            ],
            'Burritos' => [
                ['name' => 'Burrito de Carnitas', 'description' => 'Burrito com carnitas, feijão, arroz, queijo e guacamole', 'price' => 18.90, 'ingredients' => ['carnitas', 'feijão preto', 'arroz', 'queijo', 'guacamole', 'tortilla de trigo'], 'spice_level' => 'Médio'],
                ['name' => 'Burrito de Pollo', 'description' => 'Burrito com frango, feijão, arroz, queijo e pico de gallo', 'price' => 16.90, 'ingredients' => ['frango', 'feijão', 'arroz', 'queijo', 'pico de gallo', 'tortilla de trigo'], 'spice_level' => 'Suave'],
                ['name' => 'Burrito Vegetariano', 'description' => 'Burrito com feijão, arroz, guacamole, queijo e vegetais', 'price' => 15.90, 'ingredients' => ['feijão', 'arroz', 'guacamole', 'queijo', 'pimentão', 'cebola', 'tortilla de trigo'], 'spice_level' => 'Suave'],
                ['name' => 'Burrito de Carne Asada', 'description' => 'Burrito com carne bovina grelhada, feijão, arroz e molho picante', 'price' => 19.90, 'ingredients' => ['carne asada', 'feijão', 'arroz', 'molho picante', 'tortilla de trigo'], 'spice_level' => 'Picante'],
                ['name' => 'Burrito de Barbacoa', 'description' => 'Burrito com barbacoa, feijão, arroz, queijo e sour cream', 'price' => 20.90, 'ingredients' => ['barbacoa', 'feijão', 'arroz', 'queijo', 'sour cream', 'tortilla de trigo'], 'spice_level' => 'Médio'],
                ['name' => 'Burrito de Camarão', 'description' => 'Burrito com camarão temperado, arroz, feijão e molho chipotle', 'price' => 22.90, 'ingredients' => ['camarão', 'arroz', 'feijão', 'molho chipotle', 'tortilla de trigo'], 'spice_level' => 'Picante'],
            ],
            'Quesadillas' => [
                ['name' => 'Quesadilla de Pollo', 'description' => 'Quesadilla com frango e queijo derretido', 'price' => 13.90, 'ingredients' => ['frango', 'queijo monterey jack', 'tortilla de trigo'], 'spice_level' => 'Suave'],
                ['name' => 'Quesadilla de Carnitas', 'description' => 'Quesadilla com carnitas e queijo derretido', 'price' => 14.90, 'ingredients' => ['carnitas', 'queijo monterey jack', 'tortilla de trigo'], 'spice_level' => 'Médio'],
                ['name' => 'Quesadilla de Vegetais', 'description' => 'Quesadilla com pimentão, cebola e queijo', 'price' => 12.90, 'ingredients' => ['pimentão', 'cebola', 'queijo monterey jack', 'tortilla de trigo'], 'spice_level' => 'Suave'],
                ['name' => 'Quesadilla de Camarão', 'description' => 'Quesadilla com camarão temperado e queijo', 'price' => 17.90, 'ingredients' => ['camarão', 'queijo monterey jack', 'coentro', 'tortilla de trigo'], 'spice_level' => 'Médio'],
                ['name' => 'Quesadilla de Cogumelos', 'description' => 'Quesadilla com cogumelos, queijo e espinafre', 'price' => 13.90, 'ingredients' => ['cogumelos', 'queijo monterey jack', 'espinafre', 'tortilla de trigo'], 'spice_level' => 'Suave'],
            ],
            'Nachos' => [
                ['name' => 'Nachos Supreme', 'description' => 'Nachos com carne, queijo, feijão, guacamole e sour cream', 'price' => 22.90, 'ingredients' => ['tortilla chips', 'carne moída', 'queijo nacho', 'feijão', 'guacamole', 'sour cream'], 'spice_level' => 'Médio'],
                ['name' => 'Nachos Vegetarianos', 'description' => 'Nachos com feijão, queijo, guacamole e jalapeños', 'price' => 18.90, 'ingredients' => ['tortilla chips', 'feijão', 'queijo nacho', 'guacamole', 'jalapeños'], 'spice_level' => 'Picante'],
                ['name' => 'Nachos de Frango', 'description' => 'Nachos com frango desfiado, queijo e molho picante', 'price' => 20.90, 'ingredients' => ['tortilla chips', 'frango desfiado', 'queijo nacho', 'molho picante'], 'spice_level' => 'Picante'],
                ['name' => 'Nachos de Carnitas', 'description' => 'Nachos com carnitas, queijo, guacamole e pico de gallo', 'price' => 23.90, 'ingredients' => ['tortilla chips', 'carnitas', 'queijo nacho', 'guacamole', 'pico de gallo'], 'spice_level' => 'Médio'],
            ],
            'Bebidas' => [
                ['name' => 'Água de Horchata', 'description' => 'Bebida tradicional mexicana de arroz e canela', 'price' => 6.90, 'ingredients' => ['arroz', 'canela', 'açúcar', 'baunilha'], 'spice_level' => 'Suave'],
                ['name' => 'Água de Jamaica', 'description' => 'Bebida refrescante de hibisco', 'price' => 5.90, 'ingredients' => ['hibisco', 'açúcar', 'água'], 'spice_level' => 'Suave'],
                ['name' => 'Margarita', 'description' => 'Coquetel tradicional mexicano com tequila', 'price' => 15.90, 'ingredients' => ['tequila', 'cointreau', 'limão', 'sal'], 'spice_level' => 'Suave'],
                ['name' => 'Michelada', 'description' => 'Cerveja mexicana com limão e especiarias', 'price' => 8.90, 'ingredients' => ['cerveja', 'limão', 'sal', 'pimenta'], 'spice_level' => 'Picante'],
                ['name' => 'Água de Tamarindo', 'description' => 'Bebida refrescante de tamarindo', 'price' => 6.90, 'ingredients' => ['tamarindo', 'açúcar', 'água'], 'spice_level' => 'Suave'],
                ['name' => 'Paloma', 'description' => 'Coquetel com tequila, grapefruit e sal', 'price' => 16.90, 'ingredients' => ['tequila', 'grapefruit', 'sal', 'limão'], 'spice_level' => 'Suave'],
                ['name' => 'Cerveja Corona', 'description' => 'Cerveja mexicana servida com limão', 'price' => 7.90, 'ingredients' => ['cerveja corona', 'limão'], 'spice_level' => 'Suave'],
            ],
            'Sobremesas' => [
                ['name' => 'Churros', 'description' => 'Churros com canela e chocolate', 'price' => 10.90, 'ingredients' => ['churros', 'canela', 'chocolate'], 'spice_level' => 'Suave'],
                ['name' => 'Flan', 'description' => 'Flan com canela', 'price' => 8.90, 'ingredients' => ['flan', 'canela'], 'spice_level' => 'Suave'],
                ['name' => 'Torta de Maçã', 'description' => 'Torta de maçã com canela', 'price' => 12.90, 'ingredients' => ['torta de maçã', 'canela'], 'spice_level' => 'Suave'],
            ],
            'Entradas' => [
                ['name' => 'Nachos', 'description' => 'Nachos com queijo, guacamole e pico de gallo', 'price' => 10.90, 'ingredients' => ['nachos', 'queijo', 'guacamole', 'pico de gallo'], 'spice_level' => 'Suave'],
                ['name' => 'Taco de Frango', 'description' => 'Taco com frango, cebola e coentro', 'price' => 10.90, 'ingredients' => ['frango', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => 'Suave'],
                ['name' => 'Taco de Carne Asada', 'description' => 'Taco com carne bovina grelhada, cebola e coentro', 'price' => 13.90, 'ingredients' => ['carne asada', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => 'Médio'],
                ['name' => 'Taco de Pescado', 'description' => 'Taco com peixe grelhado, repolho e molho chipotle', 'price' => 14.90, 'ingredients' => ['peixe', 'repolho', 'molho chipotle', 'tortilla de milho'], 'spice_level' => 'Picante'],
                ['name' => 'Taco de Chorizo', 'description' => 'Taco com linguiça mexicana, cebola e pimenta', 'price' => 12.90, 'ingredients' => ['chorizo', 'cebola', 'pimenta jalapeño', 'tortilla de milho'], 'spice_level' => 'Picante'],
                ['name' => 'Taco Vegetariano', 'description' => 'Taco com feijão preto, guacamole e vegetais', 'price' => 9.90, 'ingredients' => ['feijão preto', 'guacamole', 'alface', 'tomate', 'tortilla de milho'], 'spice_level' => 'Suave'],
            ],
        ];

        foreach ($categories as $category) {
            if (isset($dishes[$category->name])) {
                $this->command->info("Criando pratos para categoria: {$category->name}");

                foreach ($dishes[$category->name] as $dishData) {
                    $dish = Dish::create([
                        'name' => $dishData['name'],
                        'description' => $dishData['description'],
                        'price' => $dishData['price'],
                        'category_id' => $category->id,
                        'image_url' => "https://via.placeholder.com/400x300/FF6B35/FFFFFF?text=" . urlencode($dishData['name']),
                        'ingredients' => $dishData['ingredients'],
                        'spice_level' => $this->getSpiceLevel($dishData['spice_level']),
                        'is_available' => true,
                    ]);

                    $this->command->line("  - {$dish->name} criado");
                }
            } else {
                $this->command->info("Categoria não encontrada nos dados: {$category->name}");
            }
        }

        $this->command->info("Cardápio mexicano criado com sucesso!");

        $totalDishes = Dish::count();
        $this->command->info("Total de pratos criados: {$totalDishes}");
    }

    private function getSpiceLevel(string $level): SpiceLevel
    {
        return match ($level) {
            'Suave' => SpiceLevel::SUAVE,
            'Médio' => SpiceLevel::MEDIO,
            'Picante' => SpiceLevel::PICANTE,
            'Muito Picante' => SpiceLevel::MUITO_PICANTE,
            default => SpiceLevel::SUAVE,
        };
    }
}
