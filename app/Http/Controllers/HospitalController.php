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
        return view('pages.admin.list-hospital', compact('hospitals'));
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
        return view('pages.pasien.stok-plasma-rs', compact('hospitals'));
    }

    /**
     * Menampilkan form untuk menambahkan rumah sakit baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.admin.hospital-create');
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
            'name'                    => 'required|string|max:255',
            'address'                 => 'required|string',
            'phone'                   => 'required|string|max:20',
            'email'                   => 'required|email|max:255',
            'website'                 => 'nullable|url|max:255',
            'image'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok_plasma_a_positif'   => 'nullable|integer|min:0',
            'stok_plasma_a_negatif'   => 'nullable|integer|min:0',
            'stok_plasma_b_positif'   => 'nullable|integer|min:0',
            'stok_plasma_b_negatif'   => 'nullable|integer|min:0',
            'stok_plasma_ab_positif'  => 'nullable|integer|min:0',
            'stok_plasma_ab_negatif'  => 'nullable|integer|min:0',
            'stok_plasma_o_positif'   => 'nullable|integer|min:0',
            'stok_plasma_o_negatif'   => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hospitals', 'public');
        }

        Hospital::create($data);

        return redirect()->route('admin.hospital.index')->with('success', 'Rumah sakit berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail rumah sakit tertentu.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\View\View
     */
    public function show(Hospital $hospital)
    {
        return view('pages.admin.hospital-show', compact('hospital'));
    }

    /**
     * Menampilkan form untuk mengedit data rumah sakit.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\View\View
     */
    public function edit(Hospital $hospital)
    {
        return view('pages.admin.hospital-edit', compact('hospital'));
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
            'name'                    => 'required|string|max:255',
            'address'                 => 'required|string',
            'phone'                   => 'required|string|max:20',
            'email'                   => 'required|email|max:255',
            'website'                 => 'nullable|url|max:255',
            'image'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok_plasma_a_positif'   => 'nullable|integer|min:0',
            'stok_plasma_a_negatif'   => 'nullable|integer|min:0',
            'stok_plasma_b_positif'   => 'nullable|integer|min:0',
            'stok_plasma_b_negatif'   => 'nullable|integer|min:0',
            'stok_plasma_ab_positif'  => 'nullable|integer|min:0',
            'stok_plasma_ab_negatif'  => 'nullable|integer|min:0',
            'stok_plasma_o_positif'   => 'nullable|integer|min:0',
            'stok_plasma_o_negatif'   => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hospitals', 'public');
        }

        $hospital->update($data);

        return redirect()->route('admin.hospital.index')->with('success', 'Data rumah sakit berhasil diperbarui.');
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

        return redirect()->route('admin.hospital.index')->with('success', 'Data rumah sakit berhasil dihapus.');
    }
}
