<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('layouts.app', ['recaptcha_site_key' => env('RECAPTCHA_SITE_KEY')]);
    }
}
