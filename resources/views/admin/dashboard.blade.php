@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="display-5 fw-bold mb-0">Dashboard Admin</h1>
            <div>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-users me-2"></i>Kelola Pengguna
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout Admin
                    </button>
                </form>
            </div>
        </div>
        <div class="col-12 mt-2">
            <p class="lead">Selamat datang di panel admin, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-primary">Total Lukisan</h5>
                            <p class="display-4 fw-bold mb-0">{{ $totalPaintings }}</p>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-paint-brush fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-success">Total Pengguna</h5>
                            <p class="display-4 fw-bold mb-0">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-success w-100">
                        <i class="fas fa-eye me-1"></i>Lihat Semua Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Lukisan Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentPaintings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Pelukis</th>
                                        <th>Pengguna</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPaintings as $painting)
                                        <tr>
                                            <td>{{ $painting->title }}</td>
                                            <td>{{ $painting->artist }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $painting->user->id) }}" class="text-decoration-none">
                                                    {{ $painting->user->name }}
                                                </a>
                                            </td>
                                            <td>{{ $painting->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('paintings.show', $painting->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada lukisan yang diupload.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Pengguna Teraktif</h5>
                </div>
                <div class="card-body">
                    @if($userWithMostPaintings)
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                @if($userWithMostPaintings->profile_picture)
                                    <img src="{{ asset('storage/' . $userWithMostPaintings->profile_picture) }}" alt="{{ $userWithMostPaintings->name }}" class="rounded-circle" width="80">
                                @else
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="fas fa-user fa-2x text-secondary"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="mb-1">{{ $userWithMostPaintings->name }}</h5>
                            <p class="text-muted">{{ $userWithMostPaintings->email }}</p>
                            <div class="badge bg-primary bg-opacity-10 text-primary p-2">
                                <i class="fas fa-paint-brush me-1"></i>
                                {{ $userWithMostPaintings->paintings_count }} Lukisan
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.users.show', $userWithMostPaintings->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-1"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada data pengguna.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 