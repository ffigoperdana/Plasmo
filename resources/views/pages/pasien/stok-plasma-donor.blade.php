<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/responsive.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="{{asset('/images/logo-favicon.png')}}" type="image/png"><title>Plasmo</title>  </head>
  <body>
    <header class="container">
        @include('components.navbar-login')
    </header>

    <main>
        <section class="hero">
            <article class="hero text-center pt-5 pb-5 container">
                <h1>Stok Plasma</h1>
                <p>Stok plasma darah yang terdapat di daerah sekitar anda</p>
            </article>
        </section>
        <section class="daftar-rs">
            <article class="daftar-rs pb-5 d-flex flex-column container">
                <div class="daftar-upper mr-3 d-flex" style="width: 100%;">
                    <h3 class="mr-auto align-self-center" style="font-size: 24px !important;">Daftar Rumah Sakit</h3>
                    <div class="btn-group mr-3">
                        <button type="button" class="btn btn-tulisan">{{ request('type') === 'rumah-sakit' ? 'Rumah Sakit' : (request('type') === 'udd' ? 'UDD' : (request('type') === 'puskesmas' ? 'Puskesmas' : 'Tempat Stok Donor')) }}</button>
                        <button type="button" class="btn dropdown-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['type' => null, 'page' => null]) }}">Semua</a>
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['type' => 'rumah-sakit', 'page' => null]) }}">Rumah Sakit</a>
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['type' => 'udd', 'page' => null]) }}">UDD</a>
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['type' => 'puskesmas', 'page' => null]) }}">Puskesmas</a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-tulisan">Waktu</button>
                        <button type="button" class="btn dropdown-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}">Terbaru</a>
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'terlama']) }}">Terlama</a>
                        </div>
                    </div>
                </div>
                <div class="content card-rs d-flex flex-wrap mt-5" style="gap: 24px;">
                    @forelse($hospitals as $hospital)
                    <article class="rumah-sakit-content" style="flex: 1; min-width: 420px; max-width: 48%;">
                        <div class="upper d-flex">
                            <img src="{{asset('/images/rumah-sakit.png')}}" alt="rumah sakit" width="150px" style="border-radius: 8px; object-fit: cover;">
                            <div class="rumah-sakit-upper align-self-center ml-4">
                                <h3 class="mb-2"><b>{{ $hospital->name }}</b></h3>
                                <p style="line-height: 140%; margin-bottom: 4px; font-size: 14px;">Lokasi: {{ $hospital->address }}</p>
                                <p style="line-height: 140%; margin-bottom: 4px; font-size: 14px;">Hotline: {{ $hospital->hotline }}</p>
                            </div>
                        </div>
                        <div class="downer mt-3 d-flex flex-column">
                            <h3 style="font-size: 14px !important;">Stok Plasma Darah:</h3>
                            <div class="golongan-darah d-flex flex-wrap">
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah A+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_a_positif }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah B+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_b_positif }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah O+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_o_positif }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah AB+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_ab_positif }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah A-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_a_negatif }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah B-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_b_negatif }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah O-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_o_negatif }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah AB-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $hospital->stok_plasma_ab_negatif }}</p></div>
                            </div>
                            <div class="button mt-4 align-self-center">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $hospital->hotline) }}?text={{ urlencode('Halo, saya ' . Auth::user()->name . ' dengan golongan darah ' . (Auth::user()->golongan_darah ?? '-') . '. Saya ingin mengajukan permohonan plasma darah di ' . $hospital->name) }}" target="_blank">
                                    <button type="button" class="primary-btn">Ajukan Permohonan</button>
                                </a>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="text-center w-100 py-5">
                        <p style="color: #888; font-size: 16px;">Belum ada data rumah sakit tersedia.</p>
                    </div>
                    @endforelse
                </div>
                <div class="daftar-downer mt-5 d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-tulisan">Tunjukan</button>
                        <button type="button" class="btn dropdown-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle</span></button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['per_page' => 2]) }}">2</a>
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['per_page' => 4]) }}">4</a>
                          <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['per_page' => 6]) }}">6</a>
                        </div>
                    </div>
                    <nav>
                        <ul class="pagination" style="margin-bottom: 0;">
                            @if($hospitals->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $hospitals->previousPageUrl() }}">&laquo;</a></li>
                            @endif
                            @foreach($hospitals->getUrlRange(1, $hospitals->lastPage()) as $page => $url)
                                <li class="page-item {{ $hospitals->currentPage() == $page ? 'active' : '' }}"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endforeach
                            @if($hospitals->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $hospitals->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                    <p style="font-size: 14px; margin-bottom: 0;">Total: <span style="color: #122D74; font-weight: 700;">{{ $hospitals->total() }}</span></p>
                </div>
            </article>
        </section>
    </main>

    @include('components.footer-login')

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
