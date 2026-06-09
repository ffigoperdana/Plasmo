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
        <section class="daftar-rs pb-5 pt-5">
            <article class="daftar-rs d-flex container">
                <div class="daftar-upper d-flex flex-column" style="width: 30%;">
                    <h3 class="mr-auto align-self-center" style="font-size: 24px !important;">Pengaturan Akun</h3>
                    <div class="list-group mt-3">
                        <a href="/user-profile" class="list-group-item list-group-item-action setting active-setting active">User Profile</a>
                        <a href="/change-password" class="list-group-item list-group-item-action setting">Ganti Password</a>
                        <a href="/change-email" class="list-group-item list-group-item-action setting">Ganti Email</a>
                    </div>
                </div>
                <div class="content-settings d-flex flex-column" style="width: 100%;">
                    @if(session('success'))
                        <div class="alert alert-success" style="border-radius: 8px;">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" style="border-radius: 8px;">
                            <ul style="margin-bottom: 0; padding-left: 16px;">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!Auth::user()->golongan_darah)
                        <div class="alert" style="background-color: #fef3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px;">
                            <strong>⚠️ Profil belum lengkap!</strong> Silakan isi golongan darah Anda untuk menggunakan semua fitur.
                        </div>
                    @endif

                    <form style="width: 100%;" method="POST" action="/user-profile/update" enctype="multipart/form-data">
                        @csrf
                        <h4 style="font-family: 'Montserrat' !important; font-weight: bold !important;">Foto Profile</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Upload Foto Profile</span>
                            </div>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="inputGroupFile01" name="profile_photo">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold; color: #122D74; font-family: 'Montserrat';">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="Masukkan Nama Lengkap Anda">
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold; color: #122D74; font-family: 'Montserrat';">Golongan Darah <span style="color: red;">*</span></label>
                            <select class="form-control" name="golongan_darah" required style="{{ !Auth::user()->golongan_darah ? 'border: 2px solid #ffc107;' : '' }}">
                                <option value="" disabled {{ !Auth::user()->golongan_darah ? 'selected' : '' }}>Pilih Golongan Darah</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gol)
                                    <option value="{{ $gol }}" {{ Auth::user()->golongan_darah === $gol ? 'selected' : '' }}>{{ $gol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold; color: #122D74; font-family: 'Montserrat';">No. Telepon (WhatsApp)</label>
                            <input type="tel" class="form-control" name="no_telepon" value="{{ Auth::user()->no_telepon }}" placeholder="Contoh: 6281234567890">
                            <small class="form-text text-muted">Format: 62 + nomor (untuk WhatsApp)</small>
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold; color: #122D74; font-family: 'Montserrat';">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="{{ Auth::user()->alamat }}" placeholder="Masukkan Alamat Anda">
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold; color: #122D74; font-family: 'Montserrat';">Usia</label>
                            <input type="number" class="form-control" name="usia" value="{{ Auth::user()->usia }}" placeholder="Masukkan Usia Anda" min="17" max="65">
                        </div>
                        <button type="submit" style="background-color: #122D74; color: white; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; font-size: 15px; width: 100%; cursor: pointer;" class="mb-2 mt-4">Simpan Perubahan</button>
                    </form>
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
