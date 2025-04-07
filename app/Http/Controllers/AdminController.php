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
        $attempts = AdminSettings::find(1)->attempts;

        return view('admin/admin', ['passResetTime' => $passResetTime, 'attempts' => $attempts]);
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
        ]);


        return redirect()->route('dashboard')->with('success', 'Politique de mot de passe mise à jour.');
    }
}
