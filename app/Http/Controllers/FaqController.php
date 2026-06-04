<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

/**
 * FaqController
 *
 * Controller untuk mengelola data FAQ (Frequently Asked Questions)
 * pada aplikasi donor plasma darah Plasmo.
 *
 * @package App\Http\Controllers
 */
class FaqController extends Controller
{
    /**
     * Menampilkan daftar semua FAQ.
     *
     * Metode ini mengambil semua data FAQ dari database dan
     * menampilkannya pada halaman admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('pages.admin.faq', compact('faqs'));
    }

    /**
     * Menampilkan form untuk membuat FAQ baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.admin.faq-create');
    }

    /**
     * Menyimpan FAQ baru ke database.
     *
     * Validasi input: pertanyaan (question) dan jawaban (answer) wajib diisi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        Faq::create($data);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail FAQ tertentu.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\View\View
     */
    public function show(Faq $faq)
    {
        return view('pages.admin.faq-show', compact('faq'));
    }

    /**
     * Menampilkan form untuk mengedit FAQ.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\View\View
     */
    public function edit(Faq $faq)
    {
        return view('pages.admin.faq-edit', compact('faq'));
    }

    /**
     * Memperbarui data FAQ yang sudah ada di database.
     *
     * Validasi input: pertanyaan (question) dan jawaban (answer) wajib diisi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $faq->update($data);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    /**
     * Menghapus FAQ dari database.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
