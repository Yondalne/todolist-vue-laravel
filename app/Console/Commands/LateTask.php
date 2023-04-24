<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use PhpParser\Node\Expr\Cast;

class LateTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:late-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set status of all tasks uncompleted to late if deadline is reached';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where("status", "=", "uncompleted")->where("deadline", "<=", Carbon::today())->get();
        foreach ($tasks as $task) {
            $task->update([
                "status" => "late",
            ]);
        }
        echo "Did it";
    }
}
