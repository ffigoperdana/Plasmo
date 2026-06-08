<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/responsive.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>List Pendonor - Plasmo</title>
    <style>
      .blur-overlay { position: relative; }
      .blur-overlay .blur-content { filter: blur(5px); pointer-events: none; user-select: none; }
      .blur-overlay .blur-warning {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        z-index: 10; background: white; padding: 24px 32px; border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15); text-align: center; max-width: 400px;
      }
      .blur-warning h4 { color: #122D74; font-weight: 700; margin-bottom: 12px; }
      .blur-warning p { color: #555; margin-bottom: 16px; }
      .blur-warning a { background-color: #122D74; color: white !important; border-radius: 8px; padding: 10px 24px; font-weight: 600; text-decoration: none; display: inline-block; }
      .blur-warning a:hover { background-color: #0e2259; color: white !important; }
    </style>
  </head>
  <body>
    <header class="container">
        @include('components.navbar-login')
    </header>

    <main>
        <section class="hero">
            <article class="hero text-center pt-5 pb-5 container">
                <h1>Daftar Pendonor</h1>
                <p>Daftar pendonor yang terdapat di daerah sekitar anda</p>
                @if($golonganDarah)
                    <p style="color: #122D74; font-weight: 600;">Menampilkan pendonor dengan golongan darah: {{ $golonganDarah }}</p>
                @endif
            </article>
        </section>
        <section class="daftar-rs">
            <article class="daftar-rs pb-5 d-flex flex-column container">
                <div class="daftar-upper mr-3 d-flex" style="width: 100%;">
                    <h3 class="mr-auto align-self-center" style="font-size: 24px !important;">Daftar Pendonor</h3>
                </div>

                @if(!$golonganDarah)
                {{-- BLUR STATE: golongan darah belum diisi --}}
                <div class="blur-overlay mt-5">
                    <div class="blur-warning">
                        <h4>⚠️ Golongan Darah Belum Diisi</h4>
                        <p>Anda harus mengisi golongan darah terlebih dahulu agar kami dapat menampilkan pendonor yang sesuai dengan kebutuhan Anda.</p>
                        <a href="/user-profile">Lengkapi Profil</a>
                    </div>
                    <div class="blur-content">
                        <div class="content-pendonor" style="background-color: white;">
                            <div class="table px-3">
                                <table class="table">
                                    <thead>
                                      <tr style="color: #121F44; font-family: 'Heebo';">
                                        <th>No</th><th class="text-center">Nama Pendonor</th><th class="text-center">Golongan Darah</th><th class="text-center">Lokasi</th><th>Kontak</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr><td>1</td><td class="text-center">████████</td><td class="text-center">██</td><td class="text-center">████████</td><td>██</td></tr>
                                      <tr><td>2</td><td class="text-center">████████</td><td class="text-center">██</td><td class="text-center">████████</td><td>██</td></tr>
                                      <tr><td>3</td><td class="text-center">████████</td><td class="text-center">██</td><td class="text-center">████████</td><td>██</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                {{-- NORMAL STATE: data pendonor --}}
                <div class="content-pendonor mt-5" style="background-color: white;">
                    <div class="table px-3">
                        <table class="table">
                            <thead>
                              <tr style="color: #121F44; font-family: 'Heebo';">
                                <th scope="col">No</th>
                                <th scope="col" class="text-center">Nama Pendonor</th>
                                <th scope="col" class="text-center">Golongan Darah</th>
                                <th scope="col" class="text-center">Lokasi</th>
                                <th scope="col">Kontak</th>
                              </tr>
                            </thead>
                            <tbody style="font-family: 'Montserrat';">
                            @forelse($pendonors as $index => $pendonor)
                              <tr>
                                <th scope="row">{{ $pendonors->firstItem() + $index }}</th>
                                <td class="text-center">{{ $pendonor->name }}</td>
                                <td class="text-center"><span style="background-color: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 12px;">{{ $pendonor->golongan_darah }}</span></td>
                                <td class="text-center">{{ $pendonor->alamat ?? '-' }}</td>
                                <td>
                                    @if($pendonor->no_telepon)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendonor->no_telepon) }}?text={{ urlencode('Halo ' . $pendonor->name . ', saya ' . Auth::user()->name . ' dengan golongan darah ' . Auth::user()->golongan_darah . '. Saya membutuhkan donor plasma darah. Apakah Anda bersedia membantu?') }}" target="_blank">
                                        <div style="background-color: #31BA45; padding: 5px 10px; border-radius: 6px; display: inline-block;">
                                            <i class="fa fa-whatsapp" style="color: white; font-size: 16px;"></i>
                                        </div>
                                    </a>
                                    @else
                                    <span style="color: #999; font-size: 12px;">Tidak tersedia</span>
                                    @endif
                                </td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="5" class="text-center" style="padding: 40px; color: #888;">
                                    Belum ada pendonor dengan golongan darah {{ $golonganDarah }} yang terdaftar.
                                </td>
                              </tr>
                            @endforelse
                          </table>
                    </div>
                </div>

                @if($pendonors instanceof \Illuminate\Pagination\LengthAwarePaginator && $pendonors->hasPages())
                <div class="daftar-downer mt-5 d-flex justify-content-between align-items-center">
                    <div></div>
                    <nav>
                        <ul class="pagination" style="margin-bottom: 0;">
                            @if($pendonors->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $pendonors->previousPageUrl() }}">&laquo;</a></li>
                            @endif
                            @foreach($pendonors->getUrlRange(1, $pendonors->lastPage()) as $page => $url)
                                <li class="page-item {{ $pendonors->currentPage() == $page ? 'active' : '' }}"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endforeach
                            @if($pendonors->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $pendonors->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                    <p style="font-size: 14px; margin-bottom: 0;">Total Pendonor: <span style="color: #122D74; font-weight: 700;">{{ $pendonors->total() }}</span></p>
                </div>
                @endif
                @endif

            </article>
        </section>
    </main>

    @include('components.footer-login')

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
