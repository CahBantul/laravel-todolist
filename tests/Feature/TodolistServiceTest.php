<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "belajar");

        $todolist = Session::get("todolist");
        foreach ($todolist as  $value) {
            self::assertEquals("1", $value["id"]);
            self::assertEquals("belajar", $value["todo"]);
        };
    }

    public function testTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Belajar Laravel"
            ],
            [
                "id" => "2",
                "todo" => "makan"
            ]
        ];

        $this->todolistService->saveTodo("1", "Belajar Laravel");
        $this->todolistService->saveTodo("2", "makan");
        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Belajar");
        $this->todolistService->saveTodo("2", "makan");
        self::assertEquals("2", sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->removeTodo("3");
        self::assertEquals("2", sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->removeTodo("1");
        self::assertEquals("1", sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("2");
        self::assertEquals("0", sizeof($this->todolistService->getTodolist()));
    }
}
