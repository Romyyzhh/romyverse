@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Image Column -->
                        <div class="col-md-5">
                            <div class="position-relative h-100">
                                @if($painting->image)
                                    <img src="{{ asset('storage/' . $painting->image) }}" alt="{{ $painting->title }}" 
                                         class="w-100 h-100" style="object-fit: cover;">
                                @elseif($painting->image_url)
                                    <img src="{{ $painting->image_url }}" alt="{{ $painting->title }}" 
                                         class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-image text-muted fa-3x"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Content Column -->
                        <div class="col-md-7">
                            <div class="p-4">
                                <h2 class="mb-3 fw-bold">{{ $painting->title }}</h2>
                                
                                <div class="d-flex mb-3">
                                    <div class="me-4">
                                        <small class="text-muted d-block">Kreator</small>
                                        <span class="fw-medium">{{ $painting->artist }}</span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Tahun</small>
                                        <span class="fw-medium">{{ $painting->year }}</span>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <small class="text-muted d-block mb-2">Deskripsi</small>
    <p>{{ $painting->description }}</p>
                                </div>
                                
                                @if($painting->user)
                                <div class="mb-4">
                                    <small class="text-muted d-block mb-2">Diposting oleh</small>
                                    <a href="{{ route('profile.public', $painting->user->id) }}" class="text-decoration-none">
                                        <span>{{ $painting->user->name }}</span>
                                        <i class="fas fa-external-link-alt ms-1 small"></i>
                                    </a>
                                </div>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-3">
                                    <a href="{{ route('paintings.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <div class="d-flex">
                                        <a href="{{ route('paintings.pdf', $painting->id) }}" class="btn btn-outline-secondary me-2" target="_blank">
                                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                                        </a>
                                        
                                        @auth
                                        <form action="{{ route('paintings.like', $painting->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn {{ $painting->isLikedBy(auth()->user()) ? 'btn-danger' : 'btn-outline-danger' }}">
                                                <i class="fas {{ $painting->isLikedBy(auth()->user()) ? 'fa-heart' : 'fa-heart' }} me-1"></i>
                                                <span class="like-count">{{ $painting->likes()->count() }}</span>
                                            </button>
                                        </form>
                                        @endauth
                                        
                                        @if(Auth::id() == $painting->user_id || (Auth::check() && Auth::user()->is_admin))
                                        <a href="{{ route('paintings.edit', $painting->id) }}" class="btn btn-primary me-2">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a>
                                        <form action="{{ route('paintings.destroy', $painting->id) }}" method="POST" class="d-inline" id="delete-form">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                                <i class="fas fa-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Comments Section -->
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body">
                    <h4 class="mb-4">Komentar ({{ $comments->count() }})</h4>
                    
                    @auth
                    <form action="{{ route('comments.store', $painting->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ auth()->user()->getProfilePictureUrlAttribute() }}" alt="{{ auth()->user()->name }}" 
                                     class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <strong>{{ auth()->user()->name }}</strong>
                                    <small class="text-muted d-block">Tulis komentar Anda</small>
                                </div>
                            </div>
                            <textarea class="form-control" name="content" rows="3" placeholder="Bagikan pendapat Anda tentang karya ini..."></textarea>
                            @error('content')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Komentar
                        </button>
                    </form>
                    @else
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <a href="{{ route('login') }}">Login</a> atau <a href="{{ route('register') }}">Register</a> untuk menambahkan komentar.
                    </div>
                    @endauth
                    
                    <div class="comments-list">
                        @forelse($comments as $comment)
                            <div class="comment d-flex mb-4 pb-4 border-bottom">
                                <img src="{{ $comment->user->getProfilePictureUrlAttribute() }}" alt="{{ $comment->user->name }}" 
                                     class="rounded-circle me-3 mt-1" width="50" height="50" style="object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h5 class="mb-0">{{ $comment->user->name }}</h5>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        @auth
                                            @if(Auth::id() == $comment->user_id || Auth::user()->is_admin)
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" 
                                                            onclick="return confirm('Hapus komentar ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
    @endif
                                        @endauth
                                    </div>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus postingan ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>

<style>
.rounded-4 {
    border-radius: 0.75rem;
}

.fw-medium {
    font-weight: 500;
}
</style>
@endsection
