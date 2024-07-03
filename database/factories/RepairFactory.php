<?php

namespace Database\Factories;

use App\Models\Repair;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Repair::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => \App\Models\Client::factory()->create()->id,
            'product' => $this->faker->word,
            'category' => $this->faker->randomElement(['cocina', 'calefaccion', 'lavado', 'refrigeracion', 'otro']),
            'repair_detail' => $this->faker->sentence,
            'repair_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}
