<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            // Perbaikan dari 'status' menjadi 'completed'
            $query->where('completed', filter_var($request->status, FILTER_VALIDATE_BOOLEAN));
        }

        $tasks = $query->get();
        $categories = auth()->user()->tasks()->pluck('category')->unique();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function checkNotifications()
    {
        $tasks = auth()->user()->tasks()->whereNotNull('deadline')->get();

        foreach ($tasks as $task) {
            $deadline = Carbon::parse($task->deadline);
            $notificationTime = $deadline->subMinutes($task->notification_minutes ?? 0);

            if (Carbon::now()->greaterThanOrEqualTo($notificationTime) && Carbon::now()->lessThan($deadline)) {
                session()->flash('notification', 'Tugas "' . $task->title . '" mendekati deadline!');
            }
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'notification_minutes' => 'nullable|integer|min:1',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'notification_minutes' => 'nullable|integer|min:1',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus');
    }

    public function toggleStatus(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Mengganti 'status' menjadi 'completed'
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('completed', true)->count();
        $incompleteTasks = $user->tasks()->where('completed', false)->count();

        $upcomingTasks = $user->tasks()
            ->whereDate('deadline', '>=', now())
            ->orderBy('deadline')
            ->limit(5)
            ->get();

        $recentForums = $user->forums()
            ->orderBy('forums.updated_at', 'desc')
            ->limit(5)
            ->get();

        $popularCategories = \App\Models\Category::withCount('tasks')
            ->orderByDesc('tasks_count')
            ->limit(5)
            ->get();

        $recentNotifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('tasks.dashboard', compact(
            'totalTasks',
            'completedTasks',
            'incompleteTasks',
            'upcomingTasks',
            'recentForums',
            'popularCategories',
            'recentNotifications'
        ));
    }

    public function calendar()
    {
        $tasks = Task::all()->map(function ($task) {
            return [
                'title' => $task->title,
                'start' => $task->deadline,
                'description' => $task->description,
            ];
        });

        return view('tasks.calendar', compact('tasks'));
    }
}
