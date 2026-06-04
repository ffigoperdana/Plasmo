<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendonor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PendonorController extends Controller
{
    public function show()
    {
        $pendonors = Pendonor::all();
        return view('pages.admin.list-pendonor', compact('pendonors'));
    }

    public function showPendonor()
    {
        $pendonors = Pendonor::where('ready', 1)->get();
        return view('pages.pasien.stok-plasma-donor', compact('pendonors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'blood_list' => 'required',
            'blood_type' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'age' => 'required',
            'weight' => 'required',
            'plasma_status' => 'required',
        ]);

        $pendonor = Pendonor::updateOrCreate(
            ['user_id' => Auth::id()],
            $data + ['user_id' => Auth::id()]
        );

        return redirect()->route('dashboard-pendonor');
    }

    public function changePassword()
    {
        return view('pages.pendonor.change-password');
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
        return view('pages.pendonor.change-email');
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
        $pendonor = Pendonor::where('user_id', $userId)->firstOrFail();
        return view('pages.admin.edit-pendonor', compact('pendonor'));
    }

    public function update(Request $request, $userId)
    {
        $pendonor = Pendonor::where('user_id', $userId)->firstOrFail();
        $data = $request->validate([
            'full_name' => 'required',
            'blood_list' => 'required',
            'blood_type' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'age' => 'required',
            'weight' => 'required',
            'plasma_status' => 'required',
        ]);

        $pendonor->update($data);
        return redirect()->route('list-pendonor')->with('success', 'Pendonor updated successfully');
    }

    public function destroy($userId)
    {
        $pendonor = Pendonor::where('user_id', $userId)->firstOrFail();
        $pendonor->delete();
        return redirect()->route('list-pendonor')->with('success', 'Pendonor deleted successfully');
    }

    public function showProfile()
    {
        $pendonor = Pendonor::where('user_id', Auth::id())->first();
        return view('pages.pendonor.profile-pendonor', compact('pendonor'));
    }

    public function showDashboard()
    {
        $pendonor = Pendonor::where('user_id', Auth::id())->first();
        return view('pages.pendonor.dashboard-pendonor', compact('pendonor'));
    }

    public function toggleReady($userId)
    {
        $pendonor = Pendonor::where('user_id', $userId)->firstOrFail();
        $pendonor->ready = !$pendonor->ready;
        $pendonor->save();
        return redirect()->route('list-pendonor')->with('success', 'Pendonor ready status updated successfully');
    }
}
