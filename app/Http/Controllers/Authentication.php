<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Authentication extends BaseController
{
    function __construct(protected User $user) {}

    public function register(Request $request)
    {
        try {
            $request->validate([
                "name" => "required|string",
                "email" => "required|email|unique:users,email",
                "password" => "required|confirmed|min:6"

            ]);

            return "kampret";
        } catch (\Throwable $e) {
            return response()->json($this->ErrorResponse($e));
        }
    }
}
