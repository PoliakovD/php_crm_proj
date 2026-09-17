<?php

namespace Database\Factories;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;


class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        $departments = Department::query()->get();

        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
            'status' => ApplicationStatusEnum::NEW->value,
            'department_id' =>  $departments->random()->id,
        ];
    }
}
