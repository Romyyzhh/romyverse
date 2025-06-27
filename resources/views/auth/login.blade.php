@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header border-0 bg-primary text-white p-4 position-relative">
                    <div class="text-center">
                        <i class="fas fa-sign-in-alt fa-3x mb-3 floating"></i>
                        <h3 class="mb-0">Welcome Back, Artist</h3>
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

                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                            </label>
                            <input type="email" 
                                class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus>
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

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('register') }}" class="text-decoration-none">
                                Need an account? Register
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 floating">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-light">
                    <a href="{{ route('admin.login') }}" class="text-decoration-none">
                        <i class="fas fa-user-shield me-1"></i>Login sebagai Admin
                    </a>
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