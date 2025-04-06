<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResetTimes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    private function VerifyHashPassword($user, $inputPassword)
    {
        return  Hash::check($inputPassword . $user->salt, $user->password);
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
        if ($user && $this->VerifyHashPassword($user, $credentials['password'])) {
            Auth::login($user);

            // Remettre à zéro le nombre de tentatives de connexion
            $user->failed_attempts = 0;

            $roleRedirectPages = [
                'Préposé aux clients résidentiels' => 'residents',
                'Préposé aux clients d’affaire' => 'affaires',
                'Administrateur' => 'admin',
            ];

            // Check if the password is expired
            if ($this->isPasswordExpired($user->updated_at)) {
                return redirect()->route('password-change', ['status' => 'expired', 'name' => $user->name])->with('error', 'Votre mot de passe a expiré. Veuillez le changer.');
            }

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

    private function isPasswordExpired($lastestUserUpdate)
    {
        $passwordResetTime = PasswordResetTimes::latest()->first();
        if ($passwordResetTime) {
            $resetDate = Carbon::parse($passwordResetTime->reset_date)->toDate();
            return $lastestUserUpdate >= $resetDate;
        }
        return false;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Déconnexion réussie.');
    }

    public function showPasswordChangeForm(Request $request)
    {
        $title = $request->query('status') === 'expired' ? 'Votre mot de passe a expiré. Veuillez le changer' : 'Changement de mot de passe';
        return view('auth.passwords.password-change', ['title' => $title, 'name' => $request->query('name')]);
    }

    public function changePassword(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string',
        ]);
        $user = User::where('name', $credentials['name'])->first();
        if ($credentials['oldPassword'] === $credentials['newPassword']) {
            return back()->withErrors(['name' => 'Le nouveau mot de passe doit être différent de l’ancien mot de passe.'])->withInput();
        }
        if ($user) {
            if (!$this->VerifyHashPassword($user, $credentials['oldPassword'])) {
                return back()->withErrors(['name' => 'Ancien mot de passe incorrect'])->withInput();
            }

            $response = DatabaseController::changePassword($credentials['name'], $credentials['newPassword']);

            if ($response == 'Success') {
                return redirect()->route('dashboard')->with('success', 'Changement réussie!');
            }
        }
        return back()->withErrors(['name' => 'Identifiants incorrects.'])->withInput();
    }
}
