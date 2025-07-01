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
                <h2 class="mb-0">{{ $user->name }} Mengikuti</h2>
                <div>
                    <a href="{{ route('profile.public', $user->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
                    </a>
                    <a href="{{ route('users.followers', $user->id) }}" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-users me-2"></i>Pengikut ({{ $user->followers()->count() }})
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @if($following->count() > 0)
        <div class="row g-4">
            @foreach($following as $followed)
                <div class="col-md-6 col-lg-4">
                    <div class="user-card card h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $followed->getProfilePictureUrlAttribute() }}" alt="{{ $followed->name }}" class="user-avatar me-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $followed->name }}</h5>
                                    <div class="user-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-image me-1"></i> <strong>{{ $followed->paintings()->count() }}</strong> karya
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-users me-1"></i> <strong>{{ $followed->followers()->count() }}</strong> pengikut
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($followed->bio)
                                <p class="card-text mt-3 small text-muted">{{ Str::limit($followed->bio, 100) }}</p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('profile.public', $followed->id) }}" class="btn btn-sm btn-light">
                                    <i class="fas fa-eye me-1"></i> Lihat Profil
                                </a>
                                
                                @auth
                                    @if(Auth::id() != $followed->id)
                                        <form action="{{ route('users.follow', $followed->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ Auth::user()->isFollowing($followed) ? 'btn-secondary' : 'btn-primary' }} follow-btn">
                                                <i class="fas {{ Auth::user()->isFollowing($followed) ? 'fa-user-minus' : 'fa-user-plus' }} me-1"></i>
                                                {{ Auth::user()->isFollowing($followed) ? 'Berhenti Mengikuti' : 'Ikuti' }}
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
            {{ $following->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-user-friends empty-icon"></i>
            <h4>Belum Mengikuti Siapapun</h4>
            <p class="text-muted">{{ $user->name }} belum mengikuti pengguna lain.</p>
        </div>
    @endif
</div>
@endsection 