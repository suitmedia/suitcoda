<?php

namespace Suitcoda\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Suitcoda\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    protected $redirectPath = '/';

    use ResetsPasswords;
}
