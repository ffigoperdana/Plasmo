<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendonor;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class PlasmoController extends Controller
{
    public function dashboard()
    {
        $totalPendonors = Pendonor::count();
        $totalPasiens = Pasien::count();
        $readyPendonors = Pendonor::where('ready', 1)->count();

        return view('pages.admin.dashboard', compact('totalPendonors', 'totalPasiens', 'readyPendonors'));
    }

    public function dashboardPendonor()
    {
        return redirect()->route('dashboard-pendonor');
    }

    public function dashboardPasien()
    {
        return redirect()->route('dashboard-pasien');
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function redirectAfterLogin()
    {
        $role = Auth::user()->role->name;

        if ($role === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($role === 'pendonor') {
            return redirect()->route('dashboard-pendonor');
        } elseif ($role === 'pasien') {
            return redirect()->route('dashboard-pasien');
        }

        return redirect()->route('welcome');
    }
}
