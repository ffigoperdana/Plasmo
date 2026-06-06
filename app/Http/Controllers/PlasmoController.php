<?php

namespace App\Http\Controllers;

use App\Models\Pendonor;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class PlasmoController extends Controller
{
    public function dashboard()
    {
        $totalPendonors = Pendonor::count();
        $totalPasiens = Pasien::count();
        $readyPendonors = $totalPendonors;

        return view('pages.user.dashboard-admin', compact('totalPendonors', 'totalPasiens', 'readyPendonors'));
    }

    public function dashboardPendonor()
    {
        return redirect()->route('dashboard-pendonor');
    }

    public function dashboardPasien()
    {
        return redirect()->route('dashboard');
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function redirectAfterLogin()
    {
        $role = Auth::user()->role->name;

        if ($role === 'Administrator') {
            return redirect()->route('dashboard.admin');
        } elseif ($role === 'Pendonor') {
            return redirect()->route('dashboard-pendonor');
        } elseif ($role === 'Pencari Donor') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('welcome');
    }
}
