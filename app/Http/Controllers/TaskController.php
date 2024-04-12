<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\TaskRepositoryInterface;

class TaskController extends Controller
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get all tasks.
     */
    public function index()
    {
        try {
            $tasks = $this->taskRepository->getAllTasks();
            return response()->json([$tasks], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show a specific task.
     */
    public function show(Request $request)
    {
        try {
            $taskId = $request->route('taskId');
            $task = $this->taskRepository->getTaskById($taskId);

            if (empty($task)) {
                return back(); // Assuming back() is appropriate for your application
            }

            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
   
    /**
     * Delete a task.
     */
    public function destroy(Request $request)
    {
        try {
            $taskId = $request->route('taskId');
            $task = $this->taskRepository->getTaskById($taskId);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            $this->taskRepository->deleteTask($taskId);

            return response()->json(['message' => 'Task with ' . $taskId . ' has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
