<?php
namespace App\Interfaces;

interface TaskRepositoryInterface
{
    public function getAllTasks();
    public function getTaskById($taskId);
    public function deleteTask($taskId);
}