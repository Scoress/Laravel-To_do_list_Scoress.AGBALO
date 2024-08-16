<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->orderBy('created_at', 'desc')->paginate(15);
        return view('tasks.index', compact('tasks'));

        //     $tasks = auth()->user()->tasks()->orderBy('created_at', 'desc')->get();
        // return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:55',
            'description' => 'required|string|max:200',
            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
        ]);

        Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'due_date' => $request->input('due_date'),
            'priority' => $request->input('priority'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    { {
            // $this->authorize('update', $task);
            //

            $request->validate([
                'title' => 'required|string|max:55',
                'description' => 'required|string|max:200',
                'start_date' => 'required|date|before_or_equal:due_date',
                'due_date' => 'required|date|after_or_equal:start_date',
                'priority' => 'required|in:low,medium,high',
            ]);

            $task->update($request->all());

            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
