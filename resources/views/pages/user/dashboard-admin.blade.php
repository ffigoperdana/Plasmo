<x-app-layout>
    <x-slot name="header_content">
        <h1>Dashboard</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Overview</div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon" style="background-color: #6366f1; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 20px auto 0;">
                    <i class="fa fa-users" style="font-size: 28px; color: white;"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header" style="text-align: center; padding-top: 15px;">
                        <h4>Total User</h4>
                    </div>
                    <div class="card-body" style="text-align: center; font-size: 28px; font-weight: 700; color: #1e293b;">
                        {{ \App\Models\User::count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon" style="background-color: #06b6d4; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 20px auto 0;">
                    <i class="fa fa-hospital-o" style="font-size: 28px; color: white;"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header" style="text-align: center; padding-top: 15px;">
                        <h4>Rumah Sakit</h4>
                    </div>
                    <div class="card-body" style="text-align: center; font-size: 28px; font-weight: 700; color: #1e293b;">
                        {{ \App\Models\Hospital::count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon" style="background-color: #f59e0b; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 20px auto 0;">
                    <i class="fa fa-newspaper-o" style="font-size: 28px; color: white;"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header" style="text-align: center; padding-top: 15px;">
                        <h4>Berita</h4>
                    </div>
                    <div class="card-body" style="text-align: center; font-size: 28px; font-weight: 700; color: #1e293b;">
                        {{ \App\Models\Berita::count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon" style="background-color: #10b981; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 20px auto 0;">
                    <i class="fa fa-question-circle" style="font-size: 28px; color: white;"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header" style="text-align: center; padding-top: 15px;">
                        <h4>FAQ</h4>
                    </div>
                    <div class="card-body" style="text-align: center; font-size: 28px; font-weight: 700; color: #1e293b;">
                        {{ \App\Models\Faq::count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Berita Terbaru</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Berita::latest()->take(5)->get() as $berita)
                                <tr>
                                    <td>{{ Str::limit($berita->judul_berita, 40) }}</td>
                                    <td>{{ $berita->created_at?->format('d M Y') ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4>User Terbaru</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\User::with('role')->latest()->take(5)->get() as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge badge-primary">{{ $user->role->name ?? '-' }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
