<?php

use Illuminate\Database\Seeder;
use App\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Task::create([
                'name' => $faker->name,
                'start' => $faker->dateTimeBetween($startDate = '-1 week', $endDate = 'now'),
                'done' => false
            ]);
        }
    }
}
