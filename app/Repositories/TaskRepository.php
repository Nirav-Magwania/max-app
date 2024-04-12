<?php
namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks()
    {
        return Task::all();
    }
    public function getTaskById($taskId)
    {
        return Task::findOrFail($taskId);
    }
    public function deleteTask($taskId)
    {
        Task::destroy($taskId);
    }


}