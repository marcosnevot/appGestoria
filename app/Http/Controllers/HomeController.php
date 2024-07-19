<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recaptchaSiteKey = config('services.recaptcha.site');

        return view('layouts.app', compact('recaptchaSiteKey'));
    }
}
