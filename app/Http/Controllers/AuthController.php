<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class AuthController extends Controller
{
    public function login(): Response
    {
        return inertia('auth/login');
    }
}
