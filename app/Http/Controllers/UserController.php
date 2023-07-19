<?php

namespace App\Http\Controllers;

use App\Http\Resources\QueryAdapterCollection;
use App\Models\User;
use GhoniJee\DxAdapter\QueryAdapter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render("user/index", ['builder' => route('user.builder')]);
    }

    public function builder(Request $request)
    {
        $data = QueryAdapter::for(User::class, $request)->paginate($request->take ?? 10);
        return new QueryAdapterCollection($data);
    }
}
