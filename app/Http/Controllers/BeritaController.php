<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::all();
        return view('pages.admin.berita', compact('beritas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/berita', 'public');
        }

        Berita::create($data);
        return redirect()->route('berita')->with('success', 'Berita created successfully');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('pages.admin.berita-edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/berita', 'public');
        }

        $berita->update($data);
        return redirect()->route('berita')->with('success', 'Berita updated successfully');
    }

    public function destroy($id)
    {
        Berita::findOrFail($id)->delete();
        return redirect()->route('berita')->with('success', 'Berita deleted successfully');
    }
}
