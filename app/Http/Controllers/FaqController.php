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
        return view('pages.faq.faq-data', compact('faqs'));
    }

    /**
     * Menampilkan form untuk membuat FAQ baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.faq.faq-new');
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
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
        ]);

        Faq::create($data);

        return redirect()->route('faq')->with('success', 'FAQ berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail FAQ tertentu.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\View\View
     */
    public function show(Faq $faq)
    {
        $faqs = Faq::latest()->get();
        return view('pages.faq.faq-data', compact('faqs'));
    }

    /**
     * Menampilkan form untuk mengedit FAQ.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\View\View
     */
    public function edit(Faq $faq)
    {
        return view('pages.faq.faq-edit', compact('faq'));
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
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
        ]);

        $faq->update($data);

        return redirect()->route('faq')->with('success', 'FAQ berhasil diperbarui.');
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

        return redirect()->route('faq')->with('success', 'FAQ berhasil dihapus.');
    }

    public function showFaq()
    {
        $faqs = Faq::latest()->get();
        return view('pages.pasien.faq', compact('faqs'));
    }
}
