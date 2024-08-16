@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}</h1>
</div>
    <div class="container bg-slate-400">
            @foreach($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="">
                        <h5>{{ $task->title }}</h5>
                        <p>{{ $task->description }}</p>
                        
                        <p>Start date: {{ $task->start_date }}</p>
                        <p>Due date: {{ $task->due_date }}</p>
                         <td class="py-2 px-4 border-b">Priority :
                        @if($task->priority === 'low')
                            <span class="text-green-600">Low</span>
                        @elseif($task->priority === 'medium')
                            <span class="text-yellow-600">Medium</span>
                        @elseif($task->priority === 'high')
                            <span class="text-red-600">High</span>
                        @endif
                        <p class="text-sm text-gray-600">Created on: {{ $task->created_at->format('d M Y, H:i') }}</p>
                    </td>

                        
                    </div>
                    <div>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
  </head>
<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <a href="{{ route('tasks.index') }}" class="text-white font-bold text-xl">Task Manager</a>
        </div>
        <div>
            <a href="{{ route('tasks.create') }}" class="text-white px-4 py-2">Create Task</a>
            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
            </form>
        </div>
    </div>
</nav>




