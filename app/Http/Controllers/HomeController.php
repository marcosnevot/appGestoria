<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recaptchaSiteKey = config('services.recaptcha.site');

        return view('home', compact('recaptchaSiteKey')); // Apunta a una vista específica
    }
}
