<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit Berita') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Berita</a></div>
            <div class="breadcrumb-item"><a href="{{ route('berita') }}">Edit Berita</a></div>
        </div>
    </x-slot>
    <div class="content-settings d-flex flex-column" style="width: 100%;">
        <form style="width: 100%;" action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="text" style="font-weight: bold;font-family: 'Montserrat';">Judul Berita</label>
                <input type="text" class="form-control" id="judul-berita" name="judul_berita" value="{{ $berita->judul_berita}}">
            </div>
            <div class="form-group">
                <label for="text" style="font-weight: bold; font-family: 'Montserrat';">Isi Berita</label>
                <textarea class="form-control" id="isi-berita" name="isi_berita" rows="5">{{ $berita->isi_berita}}</textarea>
            </div>                   
            <button type="submit" class="btn-submit mb-2 mt-4" style="background-color: #3b82f6; color: white; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; font-size: 15px; width: 100%; cursor: pointer;">Simpan Perubahan</button>
        </form>
    </div>
</x-app-layout>
