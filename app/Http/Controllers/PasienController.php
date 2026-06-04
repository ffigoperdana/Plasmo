<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function show()
    {
        $pasiens = Pasien::all();
        return view('pages.admin.list-pasien', compact('pasiens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'blood_type' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'age' => 'required',
            'weight' => 'required',
            'plasma_status' => 'required',
        ]);

        $pasien = Pasien::updateOrCreate(
            ['user_id' => Auth::id()],
            $data + ['user_id' => Auth::id()]
        );

        return redirect()->route('dashboard-pasien');
    }

    public function changePassword()
    {
        return view('pages.pasien.change-password');
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
        return view('pages.pasien.change-email');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update(['email' => $request->email]);
        return back()->with('success', 'Email updated successfully');
    }

    public function edit($userId)
    {
        $pasien = Pasien::where('user_id', $userId)->firstOrFail();
        return view('pages.admin.edit-pasien', compact('pasien'));
    }

    public function update(Request $request, $userId)
    {
        $pasien = Pasien::where('user_id', $userId)->firstOrFail();
        $data = $request->validate([
            'full_name' => 'required',
            'blood_type' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'age' => 'required',
            'weight' => 'required',
            'plasma_status' => 'required',
        ]);

        $pasien->update($data);
        return redirect()->route('list-pasien')->with('success', 'Pasien updated successfully');
    }

    public function destroy($userId)
    {
        $pasien = Pasien::where('user_id', $userId)->firstOrFail();
        $pasien->delete();
        return redirect()->route('list-pasien')->with('success', 'Pasien deleted successfully');
    }

    public function showProfile()
    {
        $pasien = Pasien::where('user_id', Auth::id())->first();
        return view('pages.pasien.profile-pasien', compact('pasien'));
    }

    public function showDashboard()
    {
        $pasien = Pasien::where('user_id', Auth::id())->first();
        return view('pages.pasien.dashboard-pasien', compact('pasien'));
    }
}
