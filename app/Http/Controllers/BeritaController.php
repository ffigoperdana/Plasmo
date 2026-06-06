<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::all();
        return view('pages.berita.berita-data', compact('beritas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul_berita' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'berita_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('berita_photo_path')) {
            $data['berita_photo_path'] = $request->file('berita_photo_path')->store('images/berita', 'public');
        }

        Berita::create($data);
        return redirect()->route('berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('pages.berita.berita-edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $data = $request->validate([
            'judul_berita' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'berita_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('berita_photo_path')) {
            $data['berita_photo_path'] = $request->file('berita_photo_path')->store('images/berita', 'public');
        }

        $berita->update($data);
        return redirect()->route('berita')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Berita::findOrFail($id)->delete();
        return redirect()->route('berita')->with('success', 'Berita berhasil dihapus.');
    }

    public function showBerita()
    {
        $beritas = Berita::latest()->get();
        return view('pages.pasien.berita', compact('beritas'));
    }
}
