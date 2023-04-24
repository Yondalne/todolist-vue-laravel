<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            "pseudo" => "required|unique:users,pseudo|min:4",
            "password" => "required|confirmed|min:8"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }

        $values = $request->all();
        $values["password"] = Hash::make($values["password"]);
        $user = User::create($values);
        $token = $user->createToken("My Todo-App")->plainTextToken;
        return response()->json([
            "status" => true,
            "user" => $user,
            "token" => $token,
            "message" => "Successfully registered",
        ]);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(["pseudo" => $request->pseudo, "password" => $request->password])) {
            // $user = auth()->user();
            // dd($request->user());
            $user = $request->user();
            $token = $user->createToken("My Todo-App")->plainTextToken;

            return response()->json([
                'status' => true,
                "user" => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json([
               'status' => false,
               'message' => 'Invalid credentials',
            ]);
        }
    }
}
