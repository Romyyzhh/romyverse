@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header border-0 bg-primary text-white p-4 position-relative">
                    <div class="text-center">
                        <i class="fas fa-user-plus fa-3x mb-3 floating"></i>
                        <h3 class="mb-0">Join Our Art Community</h3>
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
                    
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2 text-primary"></i>Full Name
                            </label>
                            <input type="text" 
                                class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                            </label>
                            <input type="email" 
                                class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <input type="password" 
                                class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-circle me-2 text-primary"></i>Confirm Password
                            </label>
                            <input type="password" 
                                class="form-control form-control-lg" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="profile_picture" class="form-label">
                                <i class="fas fa-image me-2 text-primary"></i>Profile Picture (Optional)
                            </label>
                            <input type="file" 
                                class="form-control form-control-lg @error('profile_picture') is-invalid @enderror" 
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

                        <div class="mb-4">
                            <label for="bio" class="form-label">
                                <i class="fas fa-pen me-2 text-primary"></i>Bio (Optional)
                            </label>
                            <textarea 
                                class="form-control form-control-lg @error('bio') is-invalid @enderror" 
                                id="bio" 
                                name="bio" 
                                rows="3">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                Already have an account? Login
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 floating">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </button>
                        </div>
                    </form>
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