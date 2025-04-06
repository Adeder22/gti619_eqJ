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

        // Vérifier si l'utilisateur a déjà atteint le nombre maximum de tentatives de connexion
        if ($user && $user->failed_attempts >= 3) {
            return back()->withErrors(['name' => 'Trop de tentatives de connexion échouées.Veuillez contacter un responsable'])->withInput();
        }

        // Check if the user exists and the password is correct
        if ($user && $user->password === $credentials['password']) {
            Auth::login($user);

            // Remettre à zéro le nombre de tentatives de connexion
            $user->failed_attempts = 0;

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
        //incrémenter le nombre de tentatives de connexion si l'utilisateur existe
        // et que le mot de passe est incorrect
        if ($user) {
            $user->increment('failed_attempts');
        } 
        return back()->withErrors(['name' => 'Identifiants incorrects.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Déconnexion réussie.');
    }
}