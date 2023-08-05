<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
                "user" => "nozami",
                "todolist" => [
                    [
                        "id" => "1",
                        "todo" => "makan"
                    ],
                    [
                        "id" => "2",
                        "todo" => "belajar"
                    ],
                ]
            ])->get("/todolist")
            ->assertSeeText('makan')
            ->assertSeeText('belajar');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
                "user" => "ajitama"
            ])->post("/todolist")
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccees()
    {
        $this->withSession([
                "user" => "ajitama",
            ])->post("/todolist", [
                "todo" => "makan"
            ])
            ->assertRedirect("/todolist");
    }

    public function testRemoveTodo()
    {
        $this->withSession([
                "user" => "nozami",
                "todolist" => [
                    [
                        "id" => "1",
                        "todo" => "makan"
                    ],
                    [
                        "id" => "2",
                        "todo" => "belajar"
                    ],
                ]
            ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }
}
