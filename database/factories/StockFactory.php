<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition()
    {
        return [
            'symbol' => $this->faker->unique()->word,
            'timestamp' => $this->faker->dateTime,
            'open' => $this->faker->randomFloat(2, 100, 500),
            'high' => $this->faker->randomFloat(2, 100, 500),
            'low' => $this->faker->randomFloat(2, 100, 500),
            'close' => $this->faker->randomFloat(2, 100, 500),
            'volume' => $this->faker->numberBetween(1000, 1000000),
            'previous_close' => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}
