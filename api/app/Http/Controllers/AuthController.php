<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function postLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

            /**
             * Token on success | false on fail
             *
             * @var string | boolean
             */
            $token = Auth::attempt($credentials);

            return ($token !== false)
                    ? json_encode(['jwt' => $token, 'user' => ['username' => $credentials['username']]])
                    : response('Unauthorized.', 401);
    }

}
