<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('pages.admin.user', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('user')->with('success', 'User created successfully');
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        return view('pages.admin.user-edit', compact('user'));
    }

    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($data);
        return redirect()->route('user')->with('success', 'User updated successfully');
    }

    public function destroy($userId)
    {
        User::findOrFail($userId)->delete();
        return redirect()->route('user')->with('success', 'User deleted successfully');
    }

    public function changePassword()
    {
        return view('pages.admin.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated successfully');
    }

    public function changeEmail()
    {
        return view('pages.admin.change-email');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update(['email' => $request->email]);
        return back()->with('success', 'Email updated successfully');
    }
}
