<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendonor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PendonorController extends Controller
{
    public function show()
    {
        $pendonors = Pendonor::all();
        return view('pages.pendonor.list-pendonor', compact('pendonors'));
    }

    public function showPendonor()
    {
        $pendonors = Pendonor::latest()->get();
        return view('pages.pasien.stok-plasma-donor', compact('pendonors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pendonor' => 'required|string|max:255',
            'hotline' => 'required|string|max:255',
            'NIK' => 'required|string|max:16',
            'gender' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'blood_type' => 'required|string|max:255',
            'rhesus' => 'required|string|max:255',
            'weight' => 'required|integer|min:0',
            'height' => 'required|integer|min:0',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'covid_infected' => 'required|string|max:255',
            'donors' => 'required|string|max:255',
            'donors_apheresis' => 'required|string|max:255',
            'donors_hospital' => 'required|string|max:255',
            'PCR_Positive' => 'required|date',
            'PCR_Negative' => 'required|date',
            'PCR_Positive_file' => 'nullable|file|max:2048',
            'PCR_Negative_file' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('PCR_Positive_file')) {
            $data['PCR_Positive_file'] = $request->file('PCR_Positive_file')->store('pendonor/pcr', 'public');
        }

        if ($request->hasFile('PCR_Negative_file')) {
            $data['PCR_Negative_file'] = $request->file('PCR_Negative_file')->store('pendonor/pcr', 'public');
        }

        Pendonor::create($data);

        return redirect()->route('dashboard-pendonor')->with('success', 'Data pendonor berhasil dikirim.');
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
        $pendonor = Pendonor::findOrFail($userId);
        return view('pages.pendonor.pendonor', compact('pendonor'));
    }

    public function update(Request $request, $userId)
    {
        $pendonor = Pendonor::findOrFail($userId);
        $data = $request->validate([
            'nama_pendonor' => 'required|string|max:255',
            'hotline' => 'required|string|max:255',
            'NIK' => 'required|string|max:16',
            'gender' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'blood_type' => 'required|string|max:255',
            'rhesus' => 'required|string|max:255',
            'weight' => 'required|integer|min:0',
            'height' => 'required|integer|min:0',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'covid_infected' => 'required|string|max:255',
            'donors' => 'required|string|max:255',
            'donors_apheresis' => 'required|string|max:255',
            'donors_hospital' => 'required|string|max:255',
            'PCR_Positive' => 'required|date',
            'PCR_Negative' => 'required|date',
            'PCR_Positive_file' => 'nullable|file|max:2048',
            'PCR_Negative_file' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('PCR_Positive_file')) {
            $data['PCR_Positive_file'] = $request->file('PCR_Positive_file')->store('pendonor/pcr', 'public');
        }

        if ($request->hasFile('PCR_Negative_file')) {
            $data['PCR_Negative_file'] = $request->file('PCR_Negative_file')->store('pendonor/pcr', 'public');
        }

        $pendonor->update($data);
        return redirect()->route('list-pendonor')->with('success', 'Data pendonor berhasil diperbarui.');
    }

    public function destroy($userId)
    {
        $pendonor = Pendonor::findOrFail($userId);
        $pendonor->delete();
        return redirect()->route('list-pendonor')->with('success', 'Data pendonor berhasil dihapus.');
    }

    public function showProfile()
    {
        return view('pages.pendonor.user-profile');
    }

    public function showDashboard()
    {
        return view('pages.pendonor.dashboard-pendonor');
    }

    public function toggleReady($userId)
    {
        return redirect()->route('list-pendonor')->with('success', 'Status pendonor belum didukung oleh skema database saat ini.');
    }
}
