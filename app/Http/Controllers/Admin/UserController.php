<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->filled('role')) {
            $users->where('role', $request->role);
        }

        $users = $users->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }
}