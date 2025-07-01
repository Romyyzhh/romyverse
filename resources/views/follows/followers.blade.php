@extends('layout')

@section('styles')
<style>
.user-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.user-avatar {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.follow-btn {
    transition: all 0.3s ease;
}

.follow-btn:hover {
    transform: scale(1.05);
}

.user-stats {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
}

.stat-item {
    font-size: 0.85rem;
    color: var(--secondary-color);
}

.stat-item strong {
    color: var(--primary-color);
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
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Pengikut {{ $user->name }}</h2>
                <div>
                    <a href="{{ route('profile.public', $user->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
                    </a>
                    <a href="{{ route('users.following', $user->id) }}" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-user-friends me-2"></i>Mengikuti ({{ $user->following()->count() }})
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @if($followers->count() > 0)
        <div class="row g-4">
            @foreach($followers as $follower)
                <div class="col-md-6 col-lg-4">
                    <div class="user-card card h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $follower->getProfilePictureUrlAttribute() }}" alt="{{ $follower->name }}" class="user-avatar me-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $follower->name }}</h5>
                                    <div class="user-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-image me-1"></i> <strong>{{ $follower->paintings()->count() }}</strong> karya
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-users me-1"></i> <strong>{{ $follower->followers()->count() }}</strong> pengikut
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($follower->bio)
                                <p class="card-text mt-3 small text-muted">{{ Str::limit($follower->bio, 100) }}</p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('profile.public', $follower->id) }}" class="btn btn-sm btn-light">
                                    <i class="fas fa-eye me-1"></i> Lihat Profil
                                </a>
                                
                                @auth
                                    @if(Auth::id() != $follower->id)
                                        <form action="{{ route('users.follow', $follower->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ Auth::user()->isFollowing($follower) ? 'btn-secondary' : 'btn-primary' }} follow-btn">
                                                <i class="fas {{ Auth::user()->isFollowing($follower) ? 'fa-user-minus' : 'fa-user-plus' }} me-1"></i>
                                                {{ Auth::user()->isFollowing($follower) ? 'Berhenti Mengikuti' : 'Ikuti' }}
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $followers->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-users empty-icon"></i>
            <h4>Belum Ada Pengikut</h4>
            <p class="text-muted">{{ $user->name }} belum memiliki pengikut.</p>
        </div>
    @endif
</div>
@endsection 