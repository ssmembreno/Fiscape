<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;


class RegisterController extends Controller
{
        public function showRegistrationForm(){
        return view('auth.register');
    }

    public function UserRegister(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return response()->json(['message' => 'Registrado correctamente']);
    }
}
