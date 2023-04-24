<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
    */

    protected $model = Task::class;


    public function definition(): array
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(14);
        $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d');
        $status = ["completed", "uncompleted", "late"];

        $users = User::all();
        $count = count($users);

        return [
            "title" => fake()->name(),
            "description" => fake()->text(20),
            "deadline" => $randomDate,
            "status" => $status[rand(0, 2)],
            "priority" => rand(1, 3),
            "user_id" => $users[rand(0, $count - 1)]->id
        ];
    }
}
