<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\User;

class PermissionController extends Controller
{
    public function __invoke()
    {
        $user = User::factory()->create();
        auth()->login($user);
        $user->assignPermission('admin');

        Gate::authorize('admin');
        return response()->json($user, 201);

    }


}
