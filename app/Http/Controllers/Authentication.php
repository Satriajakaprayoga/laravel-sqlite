<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Authentication extends BaseController
{
    function __construct(protected User $user) {}

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                "name" => "required|string",
                "email" => "required|email|unique:users,email",
                "password" => "required|confirmed|min:6"

            ]);
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];

            $this->user->create($data);
            DB::commit();

            return response()->json($this->SuccessResponse([], 'Success create new account'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json($this->ErrorResponse($e));
        }
    }

    public function login(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd(request()->user());
            $request->validate([
                "email" => "required|email",
                "password" => "required|min:6"
            ]);

            $credential = request(['email', 'password']);
            DB::enableQueryLog();
            Auth::attempt($credential);
            dd(DB::getQueryLog());
            if (!Auth::attempt($credential)) {
                return response()->json($this->ErrorResponse('Your credential is wrong, try again'));
            }

            dd(request()->user());
            return "Success";
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json($this->ErrorResponse($e));
        }
    }
}
