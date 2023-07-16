<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task= new Task();
        $task->title= 'Task 1 title';
        $task->description= 'Task 1 Description';
        $task->priority= '1';
        $task->due_date= '2021-01-01';
        $task->save();

        $task= new Task();
        $task->title= 'Task 2 title';
        $task->description= 'Task 2 Description';
        $task->priority= '2';
        $task->due_date= '2021-01-01';
        $task->save();
    }
}
