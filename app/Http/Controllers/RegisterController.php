<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AdminSettings;
use App\Http\Controllers\DatabaseController;


class RegisterController extends Controller
{
    public function index()
    {
        $settings = AdminSettings::find(1);
        $capitals = $settings->capitals;
        $special_chars = $settings->special_chars;
        $numbers = $settings->numbers;
        $length = $settings->length;

        return view('auth.register', [
            'capitals' => $capitals,
            'special_chars' => $special_chars,
            'numbers' => $numbers,
            'length' => $length
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed',
            // 'password' => 'required|string|min:4|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        $pass = $request->password;
        if (!DatabaseController::VerifyPasswordConformity($pass)){
            return back()->withErrors(['password' => 'Mot de passe pas conforme au règles'])->withInput();
        }

        // Hashing
        $salt = bin2hex(random_bytes(8));
        $final_pass = Hash::make($pass . $salt);

        // Create user
        User::create([
            'name' => $request->name,
            'password' => $final_pass,
            'salt' => $salt,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès! Veuillez vous connecter.');
    }
}
