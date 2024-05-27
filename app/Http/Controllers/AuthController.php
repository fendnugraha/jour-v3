<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login Page',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }

    public function register()
    {
        return view('auth.register', [
            'title' => 'Register Page',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
        ]);
    }

    public function users()
    {
        return view('setting.user.index', [
            'title' => 'Users Page',
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view(
            'setting.user.edit',
            [
                'title' => 'Edit User' . ' ' . $user->name,
                'user' => $user,
                'warehouses' => Warehouse::all(),
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users,email,' . $id,
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'warehouse_id' => $request->warehouse_id,
            'role' => $request->role,
        ]);

        return redirect('/setting/user')->with('success', 'User ' . $user->name . ' Telah Diupdate');
    }
}
