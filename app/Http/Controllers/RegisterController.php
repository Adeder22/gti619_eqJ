<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        // Create user
        User::create([
            'name' => $request->name,
            'password' => $request->password,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès! Veuillez vous connecter.');
    }
}