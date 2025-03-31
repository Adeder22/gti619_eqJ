<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $credentials['name'])->first();

        // Check if the user exists and the password is correct
        if ($user && $user->password === $credentials['password']) {
            Auth::login($user);

            $roleRedirectPages = [
                'Préposé aux clients résidentiels' => 'residents',
                'Préposé aux clients d’affaire' => 'affaires',
                'Administrateur' => 'admin',
            ];

            $roleName = $user->role->name;
            if (array_key_exists($roleName, $roleRedirectPages)) {
                return redirect()->route($roleRedirectPages[$roleName])->with('success', 'Connexion réussie!');
            }

            return redirect()->route('dashboard')->with('success', 'Connexion réussie!');
        }

        return back()->withErrors(['name' => 'Identifiants incorrects.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Déconnexion réussie.');
    }
}