<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    public function login(Request $request): Response
    {
        return response()->view('user.login', [
            "title" => "Login",
        ]);
    }

    public function doLogin(Request $request) : Response|RedirectResponse
    {
        $user = $request->input("user");
        $password = $request->input("password");

        // validate input
        if(empty($user) || empty($password)){
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "user or password required"
            ]);
        };

        if($this->userService->login($user, $password)){
            $request->session()->put("user", $user);
            return redirect("/");
        };

        return response()->view("user.login", [
            "title" => "Login",
            "error" => "user or password is wrong"
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");

        return redirect('/');
    }
}
