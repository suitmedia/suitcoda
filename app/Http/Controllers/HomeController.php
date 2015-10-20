<?php

namespace Suitcoda\Http\Controllers;

use Suitcoda\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('home');
    }
}
