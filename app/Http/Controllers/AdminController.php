<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetTimes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/admin');
    }

    public function updatePasswordPolicy(Request $request)
    {
        $request->validate([
            'max_day' => 'required|integer|min:1|max:90',
        ]);
        $resetDate = Carbon::now()->addDays($request->input('max_day'))->toDateString();
        PasswordResetTimes::updateOrCreate([
            ['id' => 1],
            'max_day' => $request->input('max_day'),
            'reset_date' => $resetDate
        ]);
        return redirect()->route('dashboard')->with('success', 'Politique de mot de passe mise à jour.');
    }
}
