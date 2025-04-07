<?php

namespace App\Http\Controllers;

use App\Models\SecurityLogs;
use App\Models\User;
use App\Models\AdminSettings;
use App\Models\PasswordHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DatabaseController extends Controller
{
    public static function VerifyPasswordConformity($pass)
    {
        $settings = AdminSettings::find(1);
        $capitals = $settings->capitals;
        $special_chars = $settings->special_chars;
        $numbers = $settings->numbers;
        $length = $settings->length;

        if ($capitals && strtolower($pass) == $pass) {
            return false;
        }

        if ($special_chars && !strpbrk($pass, "~!@#$%^&*()_+")) {
            return false;
        }

        if ($numbers && !strpbrk($pass, "1234567890")) {
            return false;
        }

        if ($length && strlen($pass) < $length) {
            return false;
        }

        return true;
    }

    public static function VerifyRepeatPassword($user, $pass)
    {
        $settings = AdminSettings::find(1);
        $pass_limit = $settings->old_passes;

        $name = $user->name;

        $old_passes = PasswordHistory::where('name', $name)
            ->orderByDesc('created_at')
            ->limit($pass_limit)
            ->get();

        foreach ($old_passes as $old_pass) {
            error_log($old_pass->password);
            if (Hash::check($pass . $user->salt, $old_pass->password)){
                return false;
            }
        }

        return true;
    }

    public static function changePassword($name, $newPassword)
    {
        $user = User::where('name', $name)->first();

        // Hashing
        $salt = $user->salt;
        $final_pass = Hash::make($newPassword . $salt);

        $same_pass = Hash::check($newPassword . $salt, $user->password);
        if ($user && !$same_pass) {
            //Save old password in history
            PasswordHistory::create(['name' => $user->name, 'password' => $user->password]);

            $user->password = $final_pass;
            $user->save();
          
            // Log password change
            SecurityLogs::create([
                'name' => $user->name,
                'action' => 'Password changed'
            ]);
            return 'Success';
        }
        return 'Failed';
    }
}
