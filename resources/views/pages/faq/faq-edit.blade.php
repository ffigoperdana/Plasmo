<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit Faq') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Faq</a></div>
            <div class="breadcrumb-item"><a href="{{ route('faq') }}">Edit Faq</a></div>
        </div>
    </x-slot>
    <div class="content-settings d-flex flex-column" style="width: 100%;">
        <form style="width: 100%;" action="{{ route('faq.update', $faq->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="text" style="font-weight: bold;font-family: 'Montserrat';">Pertanyaan FAQ</label>
                <input type="text" class="form-control" id="judul-faq" name="pertanyaan" value="{{$faq->pertanyaan}}">
            </div>
            <div class="form-group">
                <label for="text" style="font-weight: bold; font-family: 'Montserrat';">Jawaban FAQ</label>
                <textarea class="form-control" id="isi-faq" name="jawaban" rows="4">{{$faq->jawaban}}</textarea>
            </div>                   
            <button type="submit" class="btn-submit mb-2 mt-4" style="background-color: #3b82f6; color: white; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; font-size: 15px; width: 100%; cursor: pointer;">Simpan Perubahan</button>
        </form>
    </div>
</x-app-layout>
