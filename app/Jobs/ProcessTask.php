<?php

// app/Jobs/ProcessTask.php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTask implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $taskId;

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function handle()
    {
        $task = Task::find($this->taskId);
        if (!$task) return;

        $task->status = 'processing';
        $task->save();

        try {
            // Computational Task: Sum of first N Fibonacci numbers
            $n = $task->input['n'] ?? 10;
            $result = $this->calculateFibonacciSum($n);

            $task->status = 'completed';
            $task->result = (string) $result;
            $task->save();
        } catch (\Exception $e) {
            $task->status = 'failed';
            $task->result = $e->getMessage();
            $task->save();
        }
    }

    private function calculateFibonacciSum($n)
    {
        $a = 0;
        $b = 1;
        $sum = $a + $b;

        for ($i = 2; $i < $n; $i++) {
            $c = $a + $b;
            $sum += $c;
            $a = $b;
            $b = $c;
        }

        return $sum;
    }
}

