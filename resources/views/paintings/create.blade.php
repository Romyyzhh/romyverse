@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4 overflow-hidden">
                <div class="card-header border-0 bg-primary text-white p-4">
                    <div class="text-center">
                        <i class="fas fa-palette fa-3x mb-3 floating"></i>
                        <h3 class="mb-0">Buat Postingan Baru</h3>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" 
                        action="{{ route('paintings.store') }}" 
                        class="needs-validation" 
                        enctype="multipart/form-data"
                        novalidate>
    @csrf

                        <div class="row">
                            <!-- Image Upload Column -->
                            <div class="col-md-5 mb-4">
                                <label for="image" class="form-label fw-medium mb-3">Gambar Postingan</label>
                                <div class="image-preview-container mb-3">
                                    <div id="imagePreview" class="text-center">
                                        <img src="#" class="img-fluid preview-image" style="max-height: 250px; display: none;" alt="Preview">
                                        <div class="bg-light d-flex align-items-center justify-content-center" id="placeholder" style="height: 200px;">
                                            <i class="fas fa-image text-muted fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="file" 
                                    class="form-control @error('image') is-invalid @enderror" 
                                    id="image" 
                                    name="image" 
                                    accept="image/jpeg,image/png,image/jpg,image/gif"
                                    required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format: JPEG, PNG, JPG, GIF (maks. 20MB)
                                </div>
                            </div>
                            
                            <!-- Form Fields Column -->
                            <div class="col-md-7 mb-4">
                                <!-- Title Input -->
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-medium">Judul Postingan</label>
                                    <input type="text" 
                                        class="form-control @error('title') is-invalid @enderror" 
                                        id="title" 
                                        name="title" 
                                        value="{{ old('title') }}" 
                                        required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Description Input -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-medium">Deskripsi</label>
                                    <textarea 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        id="description" 
                                        name="description" 
                                        style="height: 200px;" 
                                        required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Hidden fields with default values -->
                                <input type="hidden" name="artist" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="year" value="{{ date('Y') }}">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                            <a href="{{ route('paintings.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rounded-4 {
    border-radius: 0.75rem;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #e9ecef;
    padding: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.image-preview-container {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 0.5rem;
    text-align: center;
}

.preview-image {
    max-height: 250px;
    object-fit: contain;
}

.btn {
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.fw-medium {
    font-weight: 500;
}
</style>

<script>
// Image preview
document.getElementById('image').onchange = function(evt) {
    const [file] = this.files;
    if (file) {
        const preview = document.querySelector('.preview-image');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        document.getElementById('placeholder').style.display = 'none';
        preview.onload = function() {
            URL.revokeObjectURL(preview.src); // free memory
        }
    }
}
</script>
@endsection
