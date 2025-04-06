<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DatabaseController extends Controller
{
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
