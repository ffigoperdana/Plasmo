<nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between">
    <a class="navbar-brand" href="/"><img src="{{asset('/images/logo.png')}}" alt="logo Plasmo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mr-auto mt-2 mt-lg-0">
            <li class="nav-item {{Request::is('/') ? 'active':''}}">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item {{Request::is('tentang-kami') ? 'active':''}}">
                <a class="nav-link" href="/tentang-kami">Tentang Kami</a>
            </li>
            <li class="nav-item {{Request::is('stok-plasma') ? 'active':''}}">
                <a class="nav-link" href="/stok-plasma">Stok Plasma</a>
            </li>
            <li class="nav-item {{Request::is('kontak') ? 'active':''}}">
                <a class="nav-link" href="/kontak">Kontak</a>
            </li>
        </ul>
        <div class="d-flex align-items-center">
            @auth
                <span class="mr-3" style="font-weight: 600; color: #122D74;">Halo, {{ Auth::user()->name }}</span>
                @php $role = Auth::user()->role->name ?? ''; @endphp
                @if($role === 'Administrator')
                    <a href="/dashboard-admin"><button type="button" class="outline-primary-btn mr-2">Dashboard</button></a>
                @elseif($role === 'Pencari Donor')
                    <a href="/dashboard"><button type="button" class="outline-primary-btn mr-2">Dashboard</button></a>
                @else
                    <a href="/dashboard-pendonor"><button type="button" class="outline-primary-btn mr-2">Dashboard</button></a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="primary-btn" style="background-color: #e74c3c;">Keluar</button>
                </form>
            @else
                <a href="/masuk"><button type="button" class="outline-primary-btn mr-3">Masuk</button></a>
                <a href="/daftar"><button type="button" class="primary-btn">Daftar</button></a>
            @endauth
        </div>
    </div>
</nav>
