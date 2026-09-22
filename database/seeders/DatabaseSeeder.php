<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ContactTypeSeeder::class,
            DepartmentSeeder::class,
            ApplicationSeeder::class,
        ]);
        if (User::count() < 30) {
            User::factory(50)
                ->has(
                    Application::factory()->count(10),'applications'
                )
                ->create();
        }
    }
}
