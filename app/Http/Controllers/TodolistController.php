<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todolist(Request $request)
    {
        $todolist  = $this->todolistService->getTodolist();
        
        return view('todolist.todolist', [
            "title" => "todolist",
            "todolist" => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input("todo");

        if(empty($todo)){
            $todolist  = $this->todolistService->getTodolist();

            return view('todolist.todolist', [
                    "title" => "todolist",
                    "todolist" => $todolist,
                    "error" => "Todo is required"
                ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, "todolist"]);
    }

    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);

        return redirect()->action([TodolistController::class, "todolist"]);
    }
}
