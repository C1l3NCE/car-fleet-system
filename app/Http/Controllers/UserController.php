<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Пользователь создан');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,operator,driver,mechanic',
        ]);

        $oldRole = $user->role;

        $user->role = $request->role;
        $user->save();

        ActivityLogger::log('user.role.change', [
            'user_id' => $user->id,
            'old'     => $oldRole,
            'new'     => $request->role,
        ]);

        return back()->with('success', 'Роль пользователя обновлена');
    }
}
