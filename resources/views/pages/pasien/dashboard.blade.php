<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="dicoding:email" content="raja.pasha.azfs@upi.edu">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/responsive.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="{{asset('/images/logo-favicon.png')}}" type="image/png"><title>Plasmo</title>  </head>
  <body>
    <header class="container">
        @include('components.navbar-login')
    </header>

    <main>
        <section class="hero">
            <article class="hero pt-5 pb-5 container">            
                <h1>Halo, {{ Auth::user()->name }}</h1>
                <p style="width: 50%;">Anda dapat mengajukan permohonan plasma darah untuk perawatan Anda melalui laman stok plasma.</p>
            </article>
        </section>
        <section class="daftar-rs">
            <article class="daftar-rs pb-5 d-flex flex-column container">                
                <div class="content dashboard d-flex">
                    <article class="rumah-sakit-content mr-3"  style="width: 100%;">
                        <h3>Kegiatan Terbaru Anda</h3>
                        <hr>
                        <p>Kegiatan Anda dalam 24 jam terakhir</p>
                        <div class="semua-kegiatan mb-4">
                            <div class="kegiatan d-flex justify-content-between mb-3">
                                <div class="content-kegiatan">
                                    <h4 style="color: black !important; font-size: 16px !important; line-height: 100% !important;">Telah Diselesaikan</h4>
                                    <p style="line-height: 100% !important; font-size: 14px !important; margin-top: 15px; margin-bottom: 0 !important;">Pendaftaran menjadi pendonor plasma darah</p>
                                </div>
                                <div class="detail-kegiatan align-self-center">
                                    <a href="#"><h4 style="font-size: 14px !important; line-height: 0 !important;">Lihat Detail</h4></a>
                                </div>
                            </div>
                            <div class="kegiatan d-flex justify-content-between mb-3">
                                <div class="content-kegiatan">
                                    <h4 style="color: black !important; font-size: 16px !important; line-height: 100% !important;">Telah Diselesaikan</h4>
                                    <p style="line-height: 100% !important; font-size: 14px !important; margin-top: 15px; margin-bottom: 0 !important;">Pendaftaran menjadi pendonor plasma darah</p>
                                </div>
                                <div class="detail-kegiatan align-self-center">
                                    <a href="#"><h4 style="font-size: 14px !important; line-height: 0 !important;">Lihat Detail</h4></a>
                                </div>
                            </div>
                            <a href="#" class="text-center"><h4 style="font-size: 16px !important;">Selengkapnya</h4></a>
                        </div>
                        
                        <a href="/faq">
                            <div class="downer action-faq mt-3 d-flex">
                                <div class="icon-faq mr-3">
                                    <i style="font-size: 36px; color: #000;" class="fa fa-question-circle"></i>
                                </div>
                                <div class="faq">
                                    <h3 style="line-height: 100%; color: #000 !important;">FAQ</h3>
                                    <p style="line-height: 150%; margin-bottom: 0 !important;">Anda dapat melihat semua pertanyaan yang sering ditanyakan pada laman ini.</p>
                                </div>                            
                            </div>   
                        </a>                        
                    </article>
                    <article class="rumah-sakit-content" style="width: 100%;">
                        <h3>Stok Plasma Tersedia</h3>
                        <hr>
                        <p>Berikut stok plasma di daerah sekitar anda :</p>
                        @php
                            $totalStok = \App\Models\Hospital::selectRaw('
                                SUM(stok_plasma_a_positif) as a_pos, SUM(stok_plasma_a_negatif) as a_neg,
                                SUM(stok_plasma_b_positif) as b_pos, SUM(stok_plasma_b_negatif) as b_neg,
                                SUM(stok_plasma_ab_positif) as ab_pos, SUM(stok_plasma_ab_negatif) as ab_neg,
                                SUM(stok_plasma_o_positif) as o_pos, SUM(stok_plasma_o_negatif) as o_neg
                            ')->first();
                        @endphp
                        <div class="downer mt-3 d-flex flex-column">
                            <div class="golongan-darah d-flex flex-wrap">
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah A+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->a_pos ?? 0 }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah B+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->b_pos ?? 0 }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah O+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->o_pos ?? 0 }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah AB+</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->ab_pos ?? 0 }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah A-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->a_neg ?? 0 }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah B-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->b_neg ?? 0 }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah O-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->o_neg ?? 0 }}</p></div>
                                <div class="gol"><h4 style="font-size: 14px !important;">Tipe Darah AB-</h4><p style="line-height: 0; font-size: 12px !important;">Sisa Stok: {{ $totalStok->ab_neg ?? 0 }}</p></div>
                            </div>
                            <div class="button mt-4 align-self-center" style="margin-bottom: 10px;">
                                <a href="/stok-plasma-donor">
                                    <button type="button" class="primary-btn mr-3 mx-auto">Lihat Semua Stok</button>
                                </a>
                            </div>
                            <a href="/berita">
                                <div class="downer action-faq mt-3 d-flex" style="background-color: rgba(42,125,245,0.3);">
                                    <div class="icon-faq mr-3" style="background-color: #2A7DF5;">
                                        <i style="font-size: 36px; color: #000;" class="fa fa-newspaper-o"></i>
                                    </div>
                                    <div class="faq">
                                        <h3 style="line-height: 100%; color: #000 !important;">Berita dan Informasi</h3>
                                        <p style="line-height: 150%; margin-bottom: 0 !important;">Anda dapat melihat semua berita dan informasi terbaru yang kami miliki melalui laman ini.</p>
                                    </div>                            
                                </div>   
                            </a>                                   
                        </div>   
                    </article>
                </div>               
        </section>
    </main>

    @include('components.footer-login')

    <!-- Popup Lengkapi Golongan Darah -->
    @if(!Auth::user()->golongan_darah)
    <div class="modal fade" id="goldarModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header" style="border-bottom: none; padding: 24px 24px 0;">
                    <h5 style="font-weight: 700; color: #122D74;">Lengkapi Profil Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="text-align: center; padding: 16px 24px 24px;">
                    <div style="margin-bottom: 16px;"><img src="{{asset('/images/logo.png')}}" alt="Plasmo" style="width: 100px;"></div>
                    <p style="color: #555; margin-bottom: 20px;">Anda belum mengisi <strong>golongan darah</strong>. Informasi ini diperlukan agar kami dapat menampilkan data yang sesuai dengan kebutuhan Anda.</p>
                    <a href="/user-profile" style="background-color: #122D74; color: white; border-radius: 8px; padding: 10px 32px; font-weight: 600; text-decoration: none; display: inline-block;">Lengkapi Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    <script>$(document).ready(function(){ $('#goldarModal').modal('show'); });</script>
    @endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
