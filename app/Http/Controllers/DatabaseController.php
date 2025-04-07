<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdminSettings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DatabaseController extends Controller
{
    public static function VerifyPasswordConformity($pass){
        $settings = AdminSettings::find(1);
        $capitals = $settings->capitals;
        $special_chars = $settings->special_chars;
        $numbers = $settings->numbers;
        $length = $settings->length;

        if ($capitals && strtolower($pass) == $pass){
            return false;
        }

        if ($special_chars && !strpbrk($pass, "~!@#$%^&*()_+")){
            return false;
        }

        if ($numbers && !strpbrk($pass, "1234567890")){
            return false;
        }
        
        if ($length && strlen($pass) < $length){
            return false;
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
            $user->password = $final_pass;
            $user->save();

            return 'Success';
        }
        return 'Failed';
    }
}
