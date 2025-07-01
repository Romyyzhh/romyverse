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
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="profile-header">
        <div class="row">
            <div class="col-lg-2 col-md-3 text-center">
                <img src="{{ $user->getProfilePictureUrlAttribute() }}" alt="{{ $user->name }}" class="profile-avatar mb-3">
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
                        <p class="text-muted">Anggota sejak {{ $user->created_at->format('M Y') }}</p>
                    </div>
                    
                    @auth
                        @if(Auth::id() != $user->id)
                            <form action="{{ route('users.follow', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ Auth::user()->isFollowing($user) ? 'btn-secondary' : 'btn-primary' }}">
                                    <i class="fas {{ Auth::user()->isFollowing($user) ? 'fa-user-minus' : 'fa-user-plus' }} me-2"></i>
                                    {{ Auth::user()->isFollowing($user) ? 'Berhenti Mengikuti' : 'Ikuti' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $paintings->count() }}</div>
                        <div class="stat-label">Lukisan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $totalLikes }}</div>
                        <div class="stat-label">Total Likes</div>
                    </div>
                    <a href="{{ route('users.followers', $user->id) }}" class="stat-item text-decoration-none">
                        <div class="stat-value">{{ $user->followers()->count() }}</div>
                        <div class="stat-label">Pengikut</div>
                    </a>
                    <a href="{{ route('users.following', $user->id) }}" class="stat-item text-decoration-none">
                        <div class="stat-value">{{ $user->following()->count() }}</div>
                        <div class="stat-label">Mengikuti</div>
                    </a>
                </div>
                
                @if($user->bio)
                <div class="profile-bio">
                    <h5>Bio</h5>
                    <p>{{ $user->bio }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Lukisan oleh {{ $user->name }}</h3>
    </div>
    
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
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-heart text-danger me-1"></i>
                                    <span>{{ $painting->likes()->count() }}</span>
                                </div>
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
            <p class="text-muted">{{ $user->name }} belum menambahkan lukisan apapun.</p>
        </div>
    @endif
</div>
@endsection 