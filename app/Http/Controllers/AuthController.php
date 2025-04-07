<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResetTimes;
use App\Models\User;
use App\Models\AdminSettings;

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
        $failedAttemptReturn = back()->withErrors(['name' => 'Trop de tentatives de connexion échouées.Veuillez contacter un responsable'])->withInput();
        function VerifyAttempts($user)
        {
            $max_attempts = AdminSettings::find(1)->attempts;
            return $user->failed_attempts >= $max_attempts;
        }

        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $credentials['name'])->first();

        // Check if it's been fifteen seconds since last attempt
        if ($user->last_attempt != null) {
            $now = Carbon::now();
            $last_attempt = Carbon::parse($user->last_attempt);
            $diff = $last_attempt->diffInSeconds($now);
            if ($diff < 15) {
                return back()->withErrors(['name' => 'Merci d\'attendre ' . strval(15 - $diff) . ' secondes avant votre prochaine tentative.'])->withInput();
            }
        }

        // Vérifier si l'utilisateur a déjà atteint le nombre maximum de tentatives de connexion
        if ($user) {
            if (VerifyAttempts($user)) return $failedAttemptReturn;
        }

        // Check if the user exists and the password is correct
        if ($user && $this->VerifyHashPassword($user, $credentials['password'])) {
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
            $user->last_attempt = Carbon::now();
            $user->save();

            $user->increment('failed_attempts');
            if (VerifyAttempts($user)) return $failedAttemptReturn;
        }
        return back()->withErrors(['name' => 'Identifiants incorrects. Merci d\'attendre 15 secondes avant votre prochaine tentative.'])->withInput();
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
        $settings = AdminSettings::find(1);
        $capitals = $settings->capitals;
        $special_chars = $settings->special_chars;
        $numbers = $settings->numbers;
        $length = $settings->length;

        $title = $request->query('status') === 'expired' ? 'Votre mot de passe a expiré. Veuillez le changer' : 'Changement de mot de passe';
        return view('auth.passwords.password-change', [
            'title' => $title,
            'name' => $request->query('name'),
            'capitals' => $capitals,
            'special_chars' => $special_chars,
            'numbers' => $numbers,
            'length' => $length
        ]);
    }

    public function changePassword(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string',
        ]);
        $user = User::where('name', $credentials['name'])->first();
        $oldPassword = $credentials['oldPassword'];
        $newPassword = $credentials['newPassword'];

        if ($oldPassword === $newPassword) {
            return back()->withErrors(['name' => 'Le nouveau mot de passe doit être différent de l’ancien mot de passe.'])->withInput();
        }
        if ($user) {
            if (!$this->VerifyHashPassword($user, $oldPassword)) {
                return back()->withErrors(['name' => 'Ancien mot de passe incorrect'])->withInput();
            }

            if (!DatabaseController::VerifyPasswordConformity($newPassword)){
                return back()->withErrors(['newPassword' => 'Mot de passe pas conforme au règles'])->withInput();
            }

            if (!DatabaseController::VerifyRepeatPassword($user, $newPassword)){
                return back()->withErrors(['newPassword' => 'Interdit d\'utiliser un ancien mot de passe'])->withInput();
            }

            $response = DatabaseController::changePassword($credentials['name'], $newPassword);

            if ($response == 'Success') {
                return redirect()->route('dashboard')->with('success', 'Changement réussie!');
            }
        }
        return back()->withErrors(['name' => 'Identifiants incorrects.'])->withInput();
    }
}
