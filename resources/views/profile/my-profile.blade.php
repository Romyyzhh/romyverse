@extends('layout')

@section('styles')
<style>
.profile-header {
    position: relative;
    background-color: var(--card-background);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

.profile-avatar {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid #fff;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

.profile-stats {
    display: flex;
    gap: 2rem;
    margin-top: 1rem;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-color);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--secondary-color);
}

.profile-bio {
    margin-top: 1.5rem;
    padding: 1rem 0;
    border-top: 1px solid var(--border-color);
}

.nav-tabs .nav-link {
    color: var(--text-color);
    border: none;
    border-bottom: 2px solid transparent;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s;
}

.nav-tabs .nav-link:hover {
    border-color: var(--primary-color);
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border-color: var(--primary-color);
    background: transparent;
}

.empty-state {
    text-align: center;
    padding: 3rem;
}

.empty-icon {
    font-size: 4rem;
    color: var(--secondary-color);
    opacity: 0.5;
    margin-bottom: 1rem;
}

.pinterest-grid {
    column-count: 4;
    column-gap: 20px;
    margin: 0 auto;
    width: 100%;
    padding: 0 10px;
}

.pin-item {
    display: inline-block;
    width: 100%;
    margin-bottom: 20px;
    break-inside: avoid;
    overflow: hidden;
    border-radius: 16px;
    transition: all 0.3s;
}

@media (max-width: 991px) {
    .pinterest-grid {
        column-count: 3;
    }
}

@media (max-width: 767px) {
    .pinterest-grid {
        column-count: 2;
    }
    
    .profile-stats {
        flex-wrap: wrap;
        gap: 1rem;
    }
}

@media (max-width: 575px) {
    .pinterest-grid {
        column-count: 1;
    }
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="profile-header">
        <div class="row">
            <div class="col-lg-2 col-md-3 text-center">
                <img src="{{ Auth::user()->getProfilePictureUrlAttribute() }}" alt="{{ Auth::user()->name }}" class="profile-avatar mb-3">
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h2 class="fw-bold mb-1">{{ Auth::user()->name }}</h2>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </a>
                </div>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $paintings->count() }}</div>
                        <div class="stat-label">Lukisan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $totalLikes }}</div>
                        <div class="stat-label">Likes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ Auth::user()->likes()->count() }}</div>
                        <div class="stat-label">Favorit</div>
                    </div>
                    <a href="{{ route('users.followers', Auth::id()) }}" class="stat-item text-decoration-none">
                        <div class="stat-value">{{ Auth::user()->followers()->count() }}</div>
                        <div class="stat-label">Pengikut</div>
                    </a>
                    <a href="{{ route('users.following', Auth::id()) }}" class="stat-item text-decoration-none">
                        <div class="stat-value">{{ Auth::user()->following()->count() }}</div>
                        <div class="stat-label">Mengikuti</div>
                    </a>
                </div>
                
                @if(Auth::user()->bio)
                <div class="profile-bio">
                    <h5>Bio</h5>
                    <p>{{ Auth::user()->bio }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" id="paintings-tab" data-bs-toggle="tab" href="#paintings" role="tab">
                <i class="fas fa-palette me-2"></i>Lukisan Saya
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="liked-tab" data-bs-toggle="tab" href="#liked" role="tab">
                <i class="fas fa-heart me-2"></i>Disukai
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="network-tab" data-bs-toggle="tab" href="#network" role="tab">
                <i class="fas fa-user-friends me-2"></i>Jaringan
            </a>
        </li>
    </ul>
    
    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="paintings" role="tabpanel">
            @if($paintings->count() > 0)
                <div class="pinterest-grid">
                    @foreach($paintings as $painting)
                        <div class="pin-item">
                            <div class="card h-100 shadow-sm">
                                <a href="{{ route('paintings.show', $painting->id) }}">
                                    @if($painting->image)
                                        <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    @elseif($painting->image_url)
                                        <img src="{{ $painting->image_url }}" alt="{{ $painting->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fas fa-image text-muted fa-3x"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $painting->title }}</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $painting->year }}</small>
                                        <span class="text-danger"><i class="fas fa-heart me-1"></i>{{ $painting->likes()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-palette empty-icon"></i>
                    <h4>Belum Ada Lukisan</h4>
                    <p class="text-muted">Anda belum menambahkan lukisan apapun.</p>
                    <a href="{{ route('paintings.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Tambah Lukisan
                    </a>
                </div>
            @endif
        </div>
        
        <div class="tab-pane fade" id="liked" role="tabpanel">
            @if(Auth::user()->likes()->count() > 0)
                <div class="pinterest-grid">
                    @foreach(Auth::user()->likedPaintings()->get() as $painting)
                        <div class="pin-item">
                            <div class="card h-100 shadow-sm">
                                <a href="{{ route('paintings.show', $painting->id) }}">
                                    @if($painting->image)
                                        <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    @elseif($painting->image_url)
                                        <img src="{{ $painting->image_url }}" alt="{{ $painting->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fas fa-image text-muted fa-3x"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $painting->title }}</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $painting->artist }} ({{ $painting->year }})</small>
                                        <form action="{{ route('paintings.like', $painting->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-heart empty-icon"></i>
                    <h4>Belum Ada Lukisan Disukai</h4>
                    <p class="text-muted">Anda belum menyukai lukisan apapun.</p>
                    <a href="{{ route('paintings.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-search me-2"></i>Jelajahi Lukisan
                    </a>
                </div>
            @endif
        </div>
        
        <div class="tab-pane fade" id="network" role="tabpanel">
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pengikut Saya</h5>
                            <a href="{{ route('users.followers', Auth::id()) }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                        <div class="card-body">
                            @if(Auth::user()->followers()->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach(Auth::user()->followers()->take(5)->get() as $follower)
                                        <div class="list-group-item px-0 py-3 d-flex align-items-center">
                                            <img src="{{ $follower->getProfilePictureUrlAttribute() }}" alt="{{ $follower->name }}" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $follower->name }}</h6>
                                                <small class="text-muted">{{ $follower->paintings()->count() }} karya</small>
                                            </div>
                                            <a href="{{ route('profile.public', $follower->id) }}" class="btn btn-sm btn-light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p>Anda belum memiliki pengikut.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Saya Mengikuti</h5>
                            <a href="{{ route('users.following', Auth::id()) }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                        <div class="card-body">
                            @if(Auth::user()->following()->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach(Auth::user()->following()->take(5)->get() as $following)
                                        <div class="list-group-item px-0 py-3 d-flex align-items-center">
                                            <img src="{{ $following->getProfilePictureUrlAttribute() }}" alt="{{ $following->name }}" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $following->name }}</h6>
                                                <small class="text-muted">{{ $following->paintings()->count() }} karya</small>
                                            </div>
                                            <div class="d-flex">
                                                <a href="{{ route('profile.public', $following->id) }}" class="btn btn-sm btn-light me-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('users.follow', $following->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                                    <p>Anda belum mengikuti siapapun.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 