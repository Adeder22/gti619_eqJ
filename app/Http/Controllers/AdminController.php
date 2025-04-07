<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetTimes;
use App\Models\AdminSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        // Password Reset Time
        $passResetTime = 1;
        $pass = PasswordResetTimes::all()->last();
        if ($pass) $passResetTime = $pass->max_day;

        // Password Attempts
        $settings = AdminSettings::find(1);
        $attempts = $settings->attempts;
        $old_passes = $settings->old_passes;
        $capitals = $settings->capitals;
        $special_chars = $settings->special_chars;
        $numbers = $settings->numbers;
        $length = $settings->length;

        return view('admin/admin', [
            'passResetTime' => $passResetTime,
            'attempts' => $attempts,
            'old_passes' => $old_passes,
            'capitals' => $capitals,
            'special_chars' => $special_chars,
            'numbers' => $numbers,
            'length' => $length,
        ]);
    }

    public function updatePasswordPolicy(Request $request)
    {
        $request->validate([
            'max_day' => 'required|integer|min:0|max:90',
        ]);
        // Password Reset Time
        $resetDate = Carbon::now()->addDays($request->input('max_day'))->toDateString();
        PasswordResetTimes::updateOrCreate([
            ['id' => 1],
            'max_day' => $request->input('max_day'),
            'reset_date' => $resetDate
        ]);

        // Password Attempts
        AdminSettings::find(1)->update([
            'attempts' => $request->input('attempt-limit-count'),
            'old_passes' => $request->input('old-password-count'),
            'capitals' => $request->input('lowercase-uppercase') == 'on',
            'special_chars' => $request->input('special-character') == 'on',
            'numbers' => $request->input('number') == 'on',
            'length' => $request->input('minLength'),
        ]);


        return redirect()->route('dashboard')->with('success', 'Politique de mot de passe mise à jour.');
    }
}
