<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        /**
         * ==========1===========
         * Validate incoming registration data
         */


        /**
         * =========2===========
         * Create new user and generate API token, set the expiration time to 1 hour
         */



        /**
         * =========3===========
         * Return success response with user data and token
         */

    }


    public function login(Request $request)
    {
        /**
         * =========4===========
         * Validate incoming login data
         */

        /**
         * =========5===========
         * Generate API token for authenticated user
         * Make the token expire in 1 hour
         */

        /**
         * =========6===========
         * Return success response with user data and token
         */

    }

    public function logout(Request $request)
    {
        /**
         * =========7===========
         * Revoke the token that was used to authenticate the current request
         */


        /**
         * =========8===========
         * Return success response
         */

    }
}
