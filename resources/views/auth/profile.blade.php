@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header border-0 bg-primary text-white p-4 position-relative">
                    <div class="text-center">
                        <i class="fas fa-user-circle fa-3x mb-3 floating"></i>
                        <h3 class="mb-0">Your Artist Profile</h3>
                    </div>
                    <div class="position-absolute top-0 end-0 p-3">
                        <div class="floating">
                            <i class="fas fa-palette fa-lg text-white-50"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="text-center">
                                @if($user->profile_picture)
                                    <img src="{{ $user->profile_picture_url }}" 
                                         class="img-fluid rounded-circle mb-3" 
                                         style="width: 200px; height: 200px; object-fit: cover;" 
                                         alt="{{ $user->name }}'s profile picture">
                                    <!-- Debug info (hanya untuk development) -->
                                    @if(config('app.debug'))
                                    <div class="small text-muted mt-1 mb-2">
                                        Path: {{ $user->profile_picture }}<br>
                                        Full URL: {{ asset('storage/' . $user->profile_picture) }}
                                    </div>
                                    @endif
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                         style="width: 200px; height: 200px;">
                                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                                    </div>
                                @endif
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <p class="text-muted">{{ $user->email }}</p>

                                <div class="mt-3">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="mb-4">Edit Profile</h4>
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-2 text-primary"></i>Full Name
                                    </label>
                                    <input type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name', $user->name) }}" 
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                                    </label>
                                    <input type="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="bio" class="form-label">
                                        <i class="fas fa-pen me-2 text-primary"></i>Bio
                                    </label>
                                    <textarea 
                                        class="form-control @error('bio') is-invalid @enderror" 
                                        id="bio" 
                                        name="bio" 
                                        rows="3">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="profile_picture" class="form-label">
                                        <i class="fas fa-image me-2 text-primary"></i>Profile Picture
                                    </label>
                                    <input type="file" 
                                        class="form-control @error('profile_picture') is-invalid @enderror" 
                                        id="profile_picture" 
                                        name="profile_picture"
                                        accept="image/*">
                                    @error('profile_picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Format yang diizinkan: JPEG, PNG, JPG, GIF (maks. 20MB)
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h5 class="mb-3">Change Password (Optional)</h5>

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">
                                        <i class="fas fa-lock me-2 text-primary"></i>Current Password
                                    </label>
                                    <input type="password" 
                                        class="form-control @error('current_password') is-invalid @enderror" 
                                        id="current_password" 
                                        name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">
                                        <i class="fas fa-key me-2 text-primary"></i>New Password
                                    </label>
                                    <input type="password" 
                                        class="form-control @error('new_password') is-invalid @enderror" 
                                        id="new_password" 
                                        name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="new_password_confirmation" class="form-label">
                                        <i class="fas fa-check-circle me-2 text-primary"></i>Confirm New Password
                                    </label>
                                    <input type="password" 
                                        class="form-control" 
                                        id="new_password_confirmation" 
                                        name="new_password_confirmation">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-5 floating">
                                        <i class="fas fa-save me-2"></i>Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        transition: all 0.3s ease;
    }

    .form-control:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,.1) !important;
    }

    .card {
        border-radius: 20px;
    }

    .card-header {
        border-radius: 20px 20px 0 0 !important;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%) !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%) !important;
        border: none;
        border-radius: 10px;
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>
@endsection 