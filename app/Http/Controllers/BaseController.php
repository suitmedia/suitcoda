<?php

namespace Suitcoda\Http\Controllers;

use Suitcoda\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Constructor for base controller
     */
    public function __construct()
    {
        $user = \Auth::user();
        \View::share('user', $user);
    }
}
