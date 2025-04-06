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

    public function login(Request $request)
    {
        function VerifyHashPassword($user, $inputPassword)
        {
            return  Hash::check($inputPassword . $user->salt, $user->password);
        }

        function VerifyFailedAttempts($user){
            if ($user->failed_attempts >= 3) {
                return back()->withErrors(['name' => 'Trop de tentatives de connexion échouées.Veuillez contacter un responsable'])->withInput();
            }
        }

        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $credentials['name'])->first();

        // Check if it's been fifteen seconds since last attempt
        $now = Carbon::now();
        $last_attempt = Carbon::parse($user->last_attempt);
        $diff = $last_attempt->diffInSeconds($now);
        if ($diff < 15) {
            return back()->withErrors(['name' => 'Merci d\'attendre ' . strval(15 - $diff) . ' secondes avant votre prchaine tentative.'])->withInput();
        }

        // Vérifier si l'utilisateur a déjà atteint le nombre maximum de tentatives de connexion
        if ($user) {
            VerifyFailedAttempts($user);
        }

        // Check if the user exists and the password is correct
        if ($user && VerifyHashPassword($user, $credentials['password'])) {
            Auth::login($user);

            // Remettre à zéro le nombre de tentatives de connexion
            $user->failed_attempts = 0;
            $user->save();

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
            VerifyFailedAttempts($user);

            $user->last_attempt = Carbon::now();
            $user->save();
        }
        return back()->withErrors(['name' => 'Identifiants incorrects. Merci d\'attendre 15 secondes avant votre prchaine tentative.'])->withInput();
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
            'password' => 'required|string',
        ]);
        $response = DatabaseController::changePassword($credentials['name'], $credentials['password']);

        if ($response == 'Success') {
            return redirect()->route('dashboard')->with('success', 'Changement réussie!');
        }

        return back()->withErrors(['name' => 'Identifiants incorrects.'])->withInput();
    }
}
