@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="display-5 fw-bold mb-0">Detail Pengguna</h1>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pengguna
            </a>
            @if(!$user->is_admin)
            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline delete-user-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-outline-danger delete-user-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                    <i class="fas fa-trash me-2"></i>Hapus Pengguna
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pengguna</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">ID:</span>
                            <span>{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">Nama:</span>
                            <span>{{ $user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">Email:</span>
                            <span>{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">Status:</span>
                            <span>
                                @if($user->is_admin)
                                    <span class="badge bg-primary">Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">Tanggal Daftar:</span>
                            <span>{{ $user->created_at->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">Jumlah Lukisan:</span>
                            <span class="badge bg-info text-dark">{{ $paintings->count() }}</span>
                        </li>
                    </ul>

                    @if($user->bio)
                        <div class="mt-3">
                            <h6 class="fw-bold">Bio:</h6>
                            <p class="text-muted">{{ $user->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Lukisan yang Diupload</h5>
                </div>
                <div class="card-body">
                    @if($paintings->count() > 0)
                        <div class="row">
                            @foreach($paintings as $painting)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        @if($painting->image)
                                            <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->title }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        @elseif($painting->image_url)
                                            <img src="{{ $painting->image_url }}" alt="{{ $painting->title }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                <i class="fas fa-image fa-3x text-secondary"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $painting->title }}</h6>
                                            <p class="card-text small text-muted">
                                                {{ $painting->artist }} ({{ $painting->year }})
                                            </p>
                                            <a href="{{ route('paintings.show', $painting->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-paint-brush fa-3x text-muted mb-3"></i>
                            <p class="lead text-muted">Pengguna ini belum mengunggah lukisan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 