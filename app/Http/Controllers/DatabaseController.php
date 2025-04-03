<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DatabaseController extends Controller
{
    //Public function takes in name, newPassword to change password of the User table
    public static function changePassword($name, $newPassword)
    {
        $user = User::where('name', $name)->first();

        if ($user && $user->password !== $newPassword) {
            $user->password = $newPassword;
            $user->save();

            return 'Success';
        }
        return 'Failed';
    }
}
