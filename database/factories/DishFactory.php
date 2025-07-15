<?php

namespace Database\Factories;

use App\Enums\SpiceLevel;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    protected $model = Dish::class;

    public function definition(): array
    {
        $dishes = [
            'Tacos' => [
                ['name' => 'Taco al Pastor', 'description' => 'Taco com carne de porco marinada, abacaxi, cebola e coentro', 'price' => 12.90, 'ingredients' => ['carne al pastor', 'abacaxi', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => SpiceLevel::MEDIO],
                ['name' => 'Taco de Carnitas', 'description' => 'Taco com carne de porco desfiada, cebola e coentro', 'price' => 11.90, 'ingredients' => ['carnitas', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Taco de Pollo', 'description' => 'Taco com frango temperado, alface e tomate', 'price' => 10.90, 'ingredients' => ['frango', 'alface', 'tomate', 'tortilla de milho'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Taco de Barbacoa', 'description' => 'Taco com carne bovina cozida lentamente, cebola e coentro', 'price' => 13.90, 'ingredients' => ['barbacoa', 'cebola', 'coentro', 'tortilla de milho'], 'spice_level' => SpiceLevel::MEDIO],
                ['name' => 'Taco de Pescado', 'description' => 'Taco com peixe grelhado, repolho e molho chipotle', 'price' => 14.90, 'ingredients' => ['peixe', 'repolho', 'molho chipotle', 'tortilla de milho'], 'spice_level' => SpiceLevel::PICANTE],
            ],
            'Burritos' => [
                ['name' => 'Burrito de Carnitas', 'description' => 'Burrito com carnitas, feijão, arroz, queijo e guacamole', 'price' => 18.90, 'ingredients' => ['carnitas', 'feijão preto', 'arroz', 'queijo', 'guacamole', 'tortilla de trigo'], 'spice_level' => SpiceLevel::MEDIO],
                ['name' => 'Burrito de Pollo', 'description' => 'Burrito com frango, feijão, arroz, queijo e pico de gallo', 'price' => 16.90, 'ingredients' => ['frango', 'feijão', 'arroz', 'queijo', 'pico de gallo', 'tortilla de trigo'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Burrito Vegetariano', 'description' => 'Burrito com feijão, arroz, guacamole, queijo e vegetais', 'price' => 15.90, 'ingredients' => ['feijão', 'arroz', 'guacamole', 'queijo', 'pimentão', 'cebola', 'tortilla de trigo'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Burrito de Carne Asada', 'description' => 'Burrito com carne bovina grelhada, feijão, arroz e molho picante', 'price' => 19.90, 'ingredients' => ['carne asada', 'feijão', 'arroz', 'molho picante', 'tortilla de trigo'], 'spice_level' => SpiceLevel::PICANTE],
            ],
            'Quesadillas' => [
                ['name' => 'Quesadilla de Pollo', 'description' => 'Quesadilla com frango e queijo derretido', 'price' => 13.90, 'ingredients' => ['frango', 'queijo monterey jack', 'tortilla de trigo'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Quesadilla de Carnitas', 'description' => 'Quesadilla com carnitas e queijo derretido', 'price' => 14.90, 'ingredients' => ['carnitas', 'queijo monterey jack', 'tortilla de trigo'], 'spice_level' => SpiceLevel::MEDIO],
                ['name' => 'Quesadilla de Vegetais', 'description' => 'Quesadilla com pimentão, cebola e queijo', 'price' => 12.90, 'ingredients' => ['pimentão', 'cebola', 'queijo monterey jack', 'tortilla de trigo'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Quesadilla de Camarão', 'description' => 'Quesadilla com camarão temperado e queijo', 'price' => 17.90, 'ingredients' => ['camarão', 'queijo monterey jack', 'coentro', 'tortilla de trigo'], 'spice_level' => SpiceLevel::MEDIO],
            ],
            'Nachos' => [
                ['name' => 'Nachos Supreme', 'description' => 'Nachos com carne, queijo, feijão, guacamole e sour cream', 'price' => 22.90, 'ingredients' => ['tortilla chips', 'carne moída', 'queijo nacho', 'feijão', 'guacamole', 'sour cream'], 'spice_level' => SpiceLevel::MEDIO],
                ['name' => 'Nachos Vegetarianos', 'description' => 'Nachos com feijão, queijo, guacamole e jalapeños', 'price' => 18.90, 'ingredients' => ['tortilla chips', 'feijão', 'queijo nacho', 'guacamole', 'jalapeños'], 'spice_level' => SpiceLevel::PICANTE],
                ['name' => 'Nachos de Frango', 'description' => 'Nachos com frango desfiado, queijo e molho picante', 'price' => 20.90, 'ingredients' => ['tortilla chips', 'frango desfiado', 'queijo nacho', 'molho picante'], 'spice_level' => SpiceLevel::PICANTE],
            ],
            'Bebidas' => [
                ['name' => 'Água de Horchata', 'description' => 'Bebida tradicional mexicana de arroz e canela', 'price' => 6.90, 'ingredients' => ['arroz', 'canela', 'açúcar', 'baunilha'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Água de Jamaica', 'description' => 'Bebida refrescante de hibisco', 'price' => 5.90, 'ingredients' => ['hibisco', 'açúcar', 'água'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Margarita', 'description' => 'Coquetel tradicional mexicano com tequila', 'price' => 15.90, 'ingredients' => ['tequila', 'cointreau', 'limão', 'sal'], 'spice_level' => SpiceLevel::SUAVE],
                ['name' => 'Michelada', 'description' => 'Cerveja mexicana com limão e especiarias', 'price' => 8.90, 'ingredients' => ['cerveja', 'limão', 'sal', 'pimenta'], 'spice_level' => SpiceLevel::PICANTE],
            ],
        ];

        $categoryName = $this->faker->randomElement(array_keys($dishes));
        $dish = $this->faker->randomElement($dishes[$categoryName]);

        $category = Category::where('name', $categoryName)->first();

        return [
            'name' => $dish['name'],
            'description' => $dish['description'],
            'price' => $dish['price'],
            'category_id' => $category ? $category->id : Category::factory(),
            'image_url' => $this->faker->imageUrl(400, 300, 'food'),
            'ingredients' => $dish['ingredients'],
            'spice_level' => $dish['spice_level'],
            'is_available' => $this->faker->boolean(85),
        ];
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }

    public function spicy(): static
    {
        return $this->state(fn (array $attributes) => [
            'spice_level' => SpiceLevel::MUITO_PICANTE,
        ]);
    }

    public function mild(): static
    {
        return $this->state(fn (array $attributes) => [
            'spice_level' => SpiceLevel::SUAVE,
        ]);
    }
}
