@extends('layout')

@section('styles')
<style>
.profile-card {
    background-color: var(--card-background);
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    overflow: hidden;
}

.profile-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    padding: 2rem;
    color: white;
    text-align: center;
}

.profile-avatar-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 1rem;
}

.profile-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.avatar-upload {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
}

.avatar-upload:hover {
    transform: scale(1.1);
}

.avatar-upload input {
    display: none;
}

.form-floating {
    margin-bottom: 1.5rem;
}

.form-floating .form-control {
    border-radius: 0.5rem;
    background-color: var(--input-bg);
    border-color: var(--border-color);
    color: var(--text-color);
}

.form-floating .form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), 0.25);
    border-color: var(--primary-color);
}

.form-floating label {
    color: var(--label-color);
}

.avatar-preview {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="profile-card">
                <div class="profile-header">
                    <h2 class="mb-1">Edit Profil</h2>
                    <p>Perbarui informasi profile Anda</p>
                </div>
                
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="text-center mb-4">
                            <div class="profile-avatar-container">
                                <div class="avatar-preview" id="avatarPreview" style="background-image: url('{{ $user->getProfilePictureUrlAttribute() }}')"></div>
                                <label class="avatar-upload" for="profile_picture">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda" value="{{ old('name', $user->name) }}" required>
                            <label for="name">Nama</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Anda" value="{{ old('email', $user->email) }}" required>
                            <label for="email">Email</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="bio" name="bio" placeholder="Ceritakan tentang diri Anda" style="height: 120px">{{ old('bio', $user->bio) }}</textarea>
                            <label for="bio">Bio</label>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5>Ganti Password</h5>
                        <p class="text-muted small mb-3">Kosongkan jika tidak ingin mengubah password</p>
                        
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password saat ini">
                            <label for="current_password">Password Saat Ini</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password baru">
                            <label for="new_password">Password Baru</label>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi password baru">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('profile') }}" class="btn btn-outline-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profilePicInput = document.getElementById('profile_picture');
    const avatarPreview = document.getElementById('avatarPreview');
    
    profilePicInput.addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.style.backgroundImage = `url(${e.target.result})`;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection 