<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'JOur Apps - Login Page',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // \dd(Auth::user());
            return \redirect()->intended('/journal');
        }

        return back()->with([
            'error' => 'Username or Password is wrong, please try again or Register new account!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect('/');
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
