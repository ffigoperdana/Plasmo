<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

/**
 * HospitalController
 *
 * Controller untuk mengelola data Rumah Sakit beserta
 * stok plasma darah yang tersedia di setiap rumah sakit.
 *
 * @package App\Http\Controllers
 */
class HospitalController extends Controller
{
    /**
     * Menampilkan daftar semua rumah sakit.
     *
     * Mengambil semua data rumah sakit dari database dan
     * menampilkannya pada halaman daftar rumah sakit.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $hospitals = Hospital::all();
        return view('pages.hospital.hospital-data', compact('hospitals'));
    }

    /**
     * Menampilkan daftar rumah sakit beserta stok plasma untuk halaman pasien.
     *
     * Memungkinkan pasien melihat ketersediaan plasma di berbagai rumah sakit.
     *
     * @return \Illuminate\View\View
     */
    public function showForPasien()
    {
        $hospitals = Hospital::all();
        return view('pages.pasien.stok-plasma-donor', compact('hospitals'));
    }

    /**
     * Menampilkan form untuk menambahkan rumah sakit baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.hospital.hospital-new');
    }

    /**
     * Menyimpan data rumah sakit baru ke database.
     *
     * Validasi mencakup data dasar rumah sakit dan stok plasma
     * untuk semua golongan darah (A, B, AB, O) positif/negatif.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'hotline' => 'required|string|regex:/^[0-9+\-\s]+$/|min:10|max:20',
            'type' => 'required|in:rumah-sakit,udd,puskesmas',
            'stok_plasma_a_positif' => 'nullable|integer|min:0',
            'stok_plasma_a_negatif' => 'nullable|integer|min:0',
            'stok_plasma_b_positif' => 'nullable|integer|min:0',
            'stok_plasma_b_negatif' => 'nullable|integer|min:0',
            'stok_plasma_ab_positif' => 'nullable|integer|min:0',
            'stok_plasma_ab_negatif' => 'nullable|integer|min:0',
            'stok_plasma_o_positif' => 'nullable|integer|min:0',
            'stok_plasma_o_negatif' => 'nullable|integer|min:0',
        ]);

        Hospital::create($data);

        return redirect()->route('hospital')->with('success', 'Rumah sakit berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail rumah sakit tertentu.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\View\View
     */
    public function show(Hospital $hospital)
    {
        $hospitals = Hospital::all();
        return view('pages.hospital.hospital-data', compact('hospitals'));
    }

    /**
     * Menampilkan form untuk mengedit data rumah sakit.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\View\View
     */
    public function edit(Hospital $hospital)
    {
        return view('pages.hospital.hospital-edit', compact('hospital'));
    }

    /**
     * Memperbarui data rumah sakit yang sudah ada di database.
     *
     * Mendukung pembaruan semua data dasar rumah sakit dan
     * stok plasma untuk setiap golongan darah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Hospital $hospital)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'hotline' => 'required|string|regex:/^[0-9+\-\s]+$/|min:10|max:20',
            'type' => 'required|in:rumah-sakit,udd,puskesmas',
            'stok_plasma_a_positif' => 'nullable|integer|min:0',
            'stok_plasma_a_negatif' => 'nullable|integer|min:0',
            'stok_plasma_b_positif' => 'nullable|integer|min:0',
            'stok_plasma_b_negatif' => 'nullable|integer|min:0',
            'stok_plasma_ab_positif' => 'nullable|integer|min:0',
            'stok_plasma_ab_negatif' => 'nullable|integer|min:0',
            'stok_plasma_o_positif' => 'nullable|integer|min:0',
            'stok_plasma_o_negatif' => 'nullable|integer|min:0',
        ]);

        $hospital->update($data);

        return redirect()->route('hospital')->with('success', 'Data rumah sakit berhasil diperbarui.');
    }

    /**
     * Menghapus data rumah sakit dari database.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Hospital $hospital)
    {
        $hospital->delete();

        return redirect()->route('hospital')->with('success', 'Data rumah sakit berhasil dihapus.');
    }

    public function publicStokPlasma(Request $request)
    {
        $query = Hospital::query();

        // Filter by type
        $type = $request->get('type');
        if ($type && in_array($type, ['rumah-sakit', 'udd', 'puskesmas'])) {
            $query->where('type', $type);
        }

        // Sort by time
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = (int) $request->get('per_page', 2);
        $hospitals = $query->paginate($perPage)->appends($request->query());
        return view('stok-plasma', compact('hospitals', 'sort', 'type'));
    }

    public function showHospital(Request $request)
    {
        $query = Hospital::query();

        $type = $request->get('type');
        if ($type && in_array($type, ['rumah-sakit', 'udd', 'puskesmas'])) {
            $query->where('type', $type);
        }

        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = (int) $request->get('per_page', 2);
        $hospitals = $query->paginate($perPage)->appends($request->query());
        return view('pages.pendonor.stok-plasma-pendonor', compact('hospitals'));
    }

    public function showHospitalPasien(Request $request)
    {
        $query = Hospital::query();

        $type = $request->get('type');
        if ($type && in_array($type, ['rumah-sakit', 'udd', 'puskesmas'])) {
            $query->where('type', $type);
        }

        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = (int) $request->get('per_page', 2);
        $hospitals = $query->paginate($perPage)->appends($request->query());
        return view('pages.pasien.stok-plasma-donor', compact('hospitals'));
    }
}
