<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class DashboardController extends Controller
{
    function index(): Response
    {
        return inertia('dashboard/index');
    }
}
