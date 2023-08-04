<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertSeeText("Login");
    }

    public function testLoginForMember()
    {
        $this->withSession([
                    "user" => "Nozami",
                    "password" => "password"
                ])->get('/login')
                ->assertRedirect("/");
    }

    public function testLoginSucces()
    {
        $response = $this->post('/login', [
            "user" => "nozami",
            "password" => "password"
        ]);

        $response->assertSessionHas("user", "nozami");
        $response->assertRedirect("/");
    }

    public function testLoginUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "nozami"
            ])->post('/login', [
                    "user" => "nozami",
                    "password" => "password"
            ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $response = $this->post('/login', []);

        $response->assertSeeText("user or password required");
    }

    public function testLoginFailed()
    {
        $response = $this->post('/login', [
            "user" => "wrong",
            "password" => "wrong"
        ]);

        $response->assertSeeText("user or password is wrong");
    }

    public function testLogout(): void
    {
        $this->withSession([
            "user" => "Nozami"
        ])->post("/logout")
            ->assertSessionMissing("user")
            ->assertRedirect("/");
    }

    public function testLogoutGuest(): void
    {
        $this->post("/logout")
            ->assertRedirect("/");
    }
}
