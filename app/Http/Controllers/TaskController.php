<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks()->with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('completed', filter_var($request->status, FILTER_VALIDATE_BOOLEAN));
        }

        $tasks = $query->get();
        $categories = Category::all();

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
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'notification_minutes' => 'nullable|integer|min:1',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit(Task $task)
    {
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
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

        return back()->with('success', 'Status tugas diperbarui.');
    }

    public function dashboard()
    {
        $user = auth()->user();

        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('completed', true)->count();
        $incompleteTasks = $user->tasks()->where('completed', false)->count();

        $upcomingTasks = $user->tasks()
            ->where('completed', false)
            ->whereNotNull('deadline')
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();


        $recentForums = $user->forums()
            ->orderBy('forums.updated_at', 'desc')
            ->limit(5)
            ->get();

        $popularCategories = Category::withCount('tasks')
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
        $tasks = auth()->user()->tasks->map(function ($task) {
            return [
                'id' => $task->id, // ← WAJIB ADA
                'title' => $task->title,
                'start' => $task->deadline,
                'description' => $task->description,
            ];
        });

        return view('tasks.calendar', compact('tasks'));
    }


        public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }



public function updateDeadline(Request $request, Task $task)
{
    $request->validate([
        'deadline' => 'required|date',
    ]);

    $task->deadline = $request->deadline;
    $task->save();

    return response()->json(['message' => 'Deadline berhasil diperbarui.']);
}

}
