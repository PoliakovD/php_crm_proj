<?php

namespace Database\Factories;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;


class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
            'status' => ApplicationStatusEnum::NEW->value,
        ];
    }
}
