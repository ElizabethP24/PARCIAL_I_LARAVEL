<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Computador;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Computador>
 */
class ComputadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Computador::class;
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->randomElement(['HP','Dell','Lenovo','Asus','Acer'])
                . ' X' . $this->faker->numberBetween(10, 50),
            'marca' => $this->faker->randomElement(['HP','Dell','Lenovo','Asus','Acer']),
            'modelo' => strtoupper($this->faker->bothify('MOD-###')),
            'procesador' => $this->faker->randomElement(['Intel i5','Intel i7','Ryzen 5','Ryzen 7']),
            'ram_gb' => $this->faker->randomElement([4, 8, 12, 16, 32, 64]),
            'almacenamiento_gb' => $this->faker->randomElement([128, 256, 512, 1024, 2048]),
            'cantidad' => $this->faker->numberBetween(0, 30),
            'precio' => $this->faker->randomFloat(2, 1200000, 7580000),
            'imagen' => 'computadores/img' . $this->faker->numberBetween(1, 10) . '.png',
            'portatil' => $this->faker->boolean(80),
            'categoria_id' => \App\Models\Categoria::inRandomOrder()->first()->id ?? \App\Models\Categoria::factory(),
            'codigo_barras' => $this->faker->unique()->ean13(),
        ];
    }
}
