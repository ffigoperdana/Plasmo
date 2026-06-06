<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function show()
    {
        $pasiens = Pasien::all();
        return view('pages.pasien.permohonan', compact('pasiens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'hotline' => 'required|string|max:255',
            'nama_pasien' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'blood_type' => 'required|string|max:255',
            'rhesus' => 'required|string|max:255',
            'hospital' => 'required|string|max:255',
            'hospital_room' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'File_TPK' => 'nullable|file|max:2048',
            'Link_TPK' => 'nullable|string|max:255',
            'jumlah_plasma' => 'required|integer|min:1',
            'vaccinated' => 'required|string|max:255',
        ]);

        if ($request->hasFile('File_TPK')) {
            $data['File_TPK'] = $request->file('File_TPK')->store('pasien/tpk', 'public');
        }

        Pasien::create($data);

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil dikirim.');
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
        $pasien = Pasien::findOrFail($userId);
        return view('pages.pasien.permohonan', compact('pasien'));
    }

    public function update(Request $request, $userId)
    {
        $pasien = Pasien::findOrFail($userId);
        $data = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'hotline' => 'required|string|max:255',
            'nama_pasien' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'blood_type' => 'required|string|max:255',
            'rhesus' => 'required|string|max:255',
            'hospital' => 'required|string|max:255',
            'hospital_room' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'File_TPK' => 'nullable|file|max:2048',
            'Link_TPK' => 'nullable|string|max:255',
            'jumlah_plasma' => 'required|integer|min:1',
            'vaccinated' => 'required|string|max:255',
        ]);

        if ($request->hasFile('File_TPK')) {
            $data['File_TPK'] = $request->file('File_TPK')->store('pasien/tpk', 'public');
        }

        $pasien->update($data);
        return redirect()->route('dashboard')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($userId)
    {
        $pasien = Pasien::findOrFail($userId);
        $pasien->delete();
        return redirect()->route('dashboard')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function showProfile()
    {
        return view('pages.pasien.user-profile');
    }

    public function showDashboard()
    {
        return view('pages.pasien.dashboard');
    }
}
