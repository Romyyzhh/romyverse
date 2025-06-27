@extends('layout')

@section('styles')
<style>
.notification-item {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    background-color: var(--card-background);
    transition: all 0.3s ease;
    position: relative;
    border-left: 4px solid transparent;
}

.notification-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.notification-item.unread {
    background-color: rgba(var(--primary-color-rgb), 0.05);
    border-left-color: var(--primary-color);
}

.notification-type {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
}

.notification-type.like {
    background-color: #dc3545;
}

.notification-type.comment {
    background-color: #198754;
}

.notification-type.system {
    background-color: #0d6efd;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.notification-meta {
    color: var(--secondary-color);
    font-size: 0.875rem;
}

.notification-time {
    margin-left: 0.5rem;
    padding-left: 0.5rem;
    border-left: 1px solid var(--border-color);
}

.notification-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.5rem;
}

.no-notifications {
    text-align: center;
    padding: 4rem 2rem;
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-bell me-2"></i>
            Notifikasi
        </h2>
        @if($notifications->count() > 0)
        <form action="{{ route('notifications.read.all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-double me-2"></i>Tandai Semua Sudah Dibaca
            </button>
        </form>
        @endif
    </div>
    
    @if($notifications->count() > 0)
        <div class="notification-list">
            @foreach($notifications as $notification)
                <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }} shadow-sm">
                    <div class="d-flex">
                        <div class="notification-type {{ $notification->type }}">
                            @if($notification->type === 'like')
                                <i class="fas fa-heart"></i>
                            @elseif($notification->type === 'comment')
                                <i class="fas fa-comment"></i>
                            @else
                                <i class="fas fa-bell"></i>
                            @endif
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">{{ $notification->message }}</div>
                            <div class="notification-meta">
                                @if($notification->fromUser)
                                    <a href="{{ route('profile.public', $notification->from_user_id) }}" class="text-decoration-none">
                                        <span>{{ $notification->fromUser->name }}</span>
                                    </a>
                                @endif
                                
                                @if($notification->painting)
                                    <span>•</span>
                                    <a href="{{ route('paintings.show', $notification->painting_id) }}" class="text-decoration-none">
                                        <span>{{ $notification->painting->title }}</span>
                                    </a>
                                @endif
                                
                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="notification-actions">
                        @if(!$notification->is_read)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai Sudah Dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Notifikasi" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center">
                {{ $notifications->links() }}
            </div>
        </div>
    @else
        <div class="no-notifications">
            <i class="fas fa-bell-slash empty-icon"></i>
            <h4>Tidak Ada Notifikasi</h4>
            <p class="text-muted">Anda belum memiliki notifikasi apapun.</p>
        </div>
    @endif
</div>
@endsection 