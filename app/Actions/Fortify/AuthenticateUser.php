<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateUser
{

    function authenticate(Request $request)
    {
        $username = $request->post(config('fortify.username'));
        $password = $request->post('password');

        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->orWhere('phone_number', $username)
            ->orWhere('phone_number', 'LIKE', "%$username%")
            ->first();

        if ($user && Hash::check($password, $user->password))
            return $user;

        return false;
    }
}
