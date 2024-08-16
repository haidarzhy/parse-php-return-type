<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * @param $test Collection<int>
     */
    public function index($test): Response
    {
        return Inertia::render('User/Index');
    }

    public function show($id): JsonResponse
    {
        return response()->json(['id' => $id]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('user.index');
    }
}
