<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit Hospital') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Hospital</a></div>
            <div class="breadcrumb-item"><a href="{{ route('hospital') }}">Edit Hospital</a></div>
        </div>
    </x-slot>

    <div class="content-settings d-flex flex-column" style="width: 100%;">
        <form style="width: 100%;" action="{{ route('hospital.update', $hospital->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="text" style="font-weight: bold;font-family: 'Montserrat';">Nama Rumah Sakit</label>
                <input type="text" class="form-control" id="nama-rumah-sakit" name="name" value = "{{ $hospital->name }}">
            </div>
            <div class="form-group">
                <label for="text" style="font-weight: bold; font-family: 'Montserrat';">Alamat Rumah Sakit</label>
                <input type="text" class="form-control" id="address" name="address" value ="{{ $hospital->address }}">
            </div>
            <div class="form-group">
                <label for="type" style="font-weight: bold; font-family: 'Montserrat';">Tipe Tempat</label>
                <select class="form-control" id="type" name="type">
                    <option value="rumah-sakit" {{ $hospital->type === 'rumah-sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                    <option value="udd" {{ $hospital->type === 'udd' ? 'selected' : '' }}>UDD (Unit Donor Darah)</option>
                    <option value="puskesmas" {{ $hospital->type === 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hotline" style="font-weight: bold; font-family: 'Montserrat';">Hotline Rumah Sakit (WhatsApp)</label>
                <input type="tel" class="form-control" id="hotline" name="hotline" value="{{ $hospital->hotline }}" pattern="[0-9+\-\s]+" title="Masukkan nomor telepon yang valid">
                <small class="form-text text-muted">Format: kode negara + nomor (contoh: 6281234567890 untuk WhatsApp)</small>
            </div>
            <div style="display:flex; flex-direction:row; justify-content: space-between;">
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma A+</label>
                    <input type="number" class="form-control" id="stok_plasma_a_positif" name="stok_plasma_a_positif" value = "{{ $hospital->stok_plasma_a_positif }}">
                </div>
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma A-</label>
                    <input type="number" class="form-control" id="stok_plasma_a_negatif" name="stok_plasma_a_negatif" value = "{{ $hospital->stok_plasma_a_negatif }}">
                </div>
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma B+</label>
                    <input type="number" class="form-control" id="stok_plasma_b_positif" name="stok_plasma_b_positif" value = "{{ $hospital->stok_plasma_b_positif }}">
                </div>
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma B-</label>
                    <input type="number" class="form-control" id="stok_plasma_b_negatif" name="stok_plasma_b_negatif" value = "{{ $hospital->stok_plasma_b_negatif }}">
                </div>
            </div> 
            <div style="display:flex; flex-direction:row; justify-content: space-between;">
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma AB+</label>
                    <input type="number" class="form-control" id="stok_plasma_ab_positif" name="stok_plasma_ab_positif" value = "{{ $hospital->stok_plasma_ab_positif }}">
                </div>
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma AB-</label>
                    <input type="number" class="form-control" id="stok_plasma_ab_negatif" name="stok_plasma_ab_negatif" value = "{{ $hospital->stok_plasma_ab_negatif }}">
                </div>
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma O+</label>
                    <input type="number" class="form-control" id="stok_plasma_o_positif" name="stok_plasma_o_positif" value = "{{ $hospital->stok_plasma_o_positif }}">
                </div>
                <div class="form-group">
                    <label for="number" style="font-weight: bold; font-family: 'Montserrat';">Stok Plasma O-</label>
                    <input type="number" class="form-control" id="stok_plasma_o_negatif" name="stok_plasma_o_negatif" value = "{{ $hospital->stok_plasma_o_negatif }}">
                </div>
            </div>                 
            <button type="submit" class="btn-submit mb-2 mt-4" style="background-color: #3b82f6; color: white; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; font-size: 15px; width: 100%; cursor: pointer;">Simpan Perubahan</button>
        </form>
    </div>
</x-app-layout>
