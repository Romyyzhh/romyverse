@extends('layout')

@section('styles')
<style>
/* Hero Carousel Styles */
.hero-carousel {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 3rem;
    height: 450px;
}

.hero-carousel .swiper {
    width: 100%;
    height: 100%;
}

.hero-carousel .swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.hero-carousel .swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slide-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 4rem 2rem 2rem;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
    text-align: left;
    z-index: 2;
}

.slide-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.slide-text {
    font-size: 1.2rem;
    opacity: 0.9;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.swiper-button-next,
.swiper-button-prev {
    width: 50px !important;
    height: 50px !important;
    background: rgba(0,0,0,0.6);
    border-radius: 50%;
    color: white !important;
    transition: all 0.3s ease;
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 24px !important;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: var(--primary-color);
    transform: scale(1.1);
}

.swiper-pagination-bullet {
    width: 12px !important;
    height: 12px !important;
    background: white !important;
    opacity: 0.5;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    background: var(--primary-color) !important;
    transform: scale(1.2);
}

@media (max-width: 768px) {
    .hero-carousel {
        height: 300px;
    }
    
    .slide-title {
        font-size: 1.8rem;
    }
    
    .slide-text {
        font-size: 1rem;
    }
}

/* Pinterest-style Masonry Layout */
.pinterest-grid {
    column-count: 5;
    column-gap: 20px;
    margin: 0 auto;
    width: 100%;
    padding: 0 10px;
}

@media (min-width: 1400px) {
    .pinterest-grid {
        column-count: 5;
        column-gap: 25px;
    }
    
    .pin-item {
        margin-bottom: 25px;
    }
}

@media (max-width: 1399px) and (min-width: 1200px) {
    .pinterest-grid {
        column-count: 4;
        column-gap: 20px;
    }
    
    .pin-item {
        margin-bottom: 20px;
    }
}

@media (max-width: 1199px) {
    .pinterest-grid {
        column-count: 4;
        column-gap: 18px;
    }
}

@media (max-width: 991px) {
    .pinterest-grid {
        column-count: 3;
        column-gap: 15px;
    }
}

@media (max-width: 767px) {
    .pinterest-grid {
        column-count: 2;
        column-gap: 12px;
    }
    
    .pin-item {
        margin-bottom: 15px;
    }
}

@media (max-width: 575px) {
    .pinterest-grid {
        column-count: 1;
    }
}

.pin-item {
    display: inline-block;
    width: 100%;
    margin-bottom: 20px;
    break-inside: avoid;
    overflow: hidden;
    border-radius: 16px;
    transition: all 0.3s;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.pin-item:hover {
    transform: translateY(-4px);
}

.pin-img-container {
    position: relative;
    overflow: hidden;
    border-radius: 16px 16px 0 0;
    width: 100%;
    cursor: zoom-in;
}

.pin-img {
    width: 100%;
    display: block;
    object-fit: cover;
    transition: transform 0.6s;
    border-radius: 16px 16px 0 0;
}

/* Memastikan foto landscape dan portrait terlihat fullscreen */
.pin-img.landscape {
    width: 100%;
    height: auto;
    aspect-ratio: 16/9;
}

.pin-img.portrait {
    width: 100%;
    height: auto;
    aspect-ratio: 2/3;
}

.pin-item:hover .pin-img {
    transform: scale(1.03);
}

.pin-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,0.6));
    opacity: 0;
    transition: all 0.3s;
    border-radius: 16px 16px 0 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 16px;
}

.pin-item:hover .pin-overlay {
    opacity: 1;
}

.pin-content {
    padding: 12px 16px;
    position: relative;
    background-color: #fff;
    border-radius: 0 0 16px 16px;
}

[data-bs-theme="dark"] .pin-content {
    background-color: #2b2b2b;
}

.pin-title {
    margin: 0;
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 0.85rem;
}

.pin-artist {
    font-size: 0.75rem;
    margin-bottom: 0;
    color: #666;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.pin-actions {
    position: absolute;
    bottom: 15px;
    right: 15px;
    display: flex;
    gap: 10px;
    z-index: 3;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s;
}

.pin-item:hover .pin-actions {
    opacity: 1;
    transform: translateY(0);
}

.pin-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background-color: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    z-index: 2;
    transition: all 0.3s;
}

.pin-item:hover .pin-badge {
    background-color: var(--primary-color);
    color: white;
}

.pin-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.3s;
    cursor: pointer;
    border: none;
    font-size: 0.9rem;
}

.pin-btn:hover {
    transform: scale(1.1);
}

.pin-btn.view {
    background-color: #0d6efd;
}

.pin-btn.edit {
    background-color: #198754;
}

.pin-btn.delete {
    background-color: #dc3545;
}

.pin-btn.view:hover {
    background-color: var(--primary-color);
    color: white;
}

.pin-btn.edit:hover {
    background-color: #6c757d;
    color: white;
}

.pin-btn.delete:hover {
    background-color: #dc3545;
    color: white;
}

.pin-btn.like {
    background-color: #f8f9fa;
    color: #dc3545;
}

.pin-btn.like:hover {
    background-color: #dc3545;
    color: white;
}

.pin-btn.like-active {
    background-color: #dc3545;
    color: white;
}

.pin-btn.like-active:hover {
    background-color: #f8f9fa;
    color: #dc3545;
}

@media (max-width: 768px) {
    .pinterest-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    }
}

/* Rest of your existing styles */
.card-img-wrapper:hover .overlay {
    opacity: 1 !important;
}

.card {
    border-radius: 15px;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
}

.badge {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.border-start {
    transition: all 0.3s ease;
}

.card:hover .border-start {
    border-left-width: 6px !important;
}

[data-bs-theme="dark"] .bg-light {
    background-color: #343a40 !important;
}

[data-bs-theme="dark"] .text-muted {
    color: #adb5bd !important;
}

[data-bs-theme="dark"] .btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
}

[data-bs-theme="dark"] .btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Carousel Styles */
.featured-carousel {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 3rem;
    position: relative;
}

.swiper {
    width: 100%;
    height: 500px;
}

.carousel-card {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.carousel-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.carousel-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 4rem 2rem 2rem;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
    opacity: 1;
    z-index: 2;
}

.carousel-card:hover .carousel-img {
    transform: scale(1.05);
}

.carousel-card:hover .carousel-overlay {
    transform: translateY(0);
    opacity: 1;
}

.carousel-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.carousel-text {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 0;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

/* Swiper Navigation Styles */
.swiper-button-next,
.swiper-button-prev {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    border-radius: 50%;
    display: flex !important;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}

.swiper-button-next {
    right: 20px;
}

.swiper-button-prev {
    left: 20px;
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px;
    font-weight: bold;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background-color: var(--primary-color);
    transform: translateY(-50%) scale(1.1);
}

.swiper-pagination {
    position: absolute;
    bottom: 20px !important;
    left: 0;
    right: 0;
    z-index: 10;
    display: flex;
    justify-content: center;
    gap: 8px;
}

.swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background-color: white;
    border-radius: 50%;
    opacity: 0.5;
    cursor: pointer;
    transition: all 0.3s ease;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    background-color: var(--primary-color);
    transform: scale(1.2);
}

@media (max-width: 768px) {
    .swiper {
        height: 300px;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        width: 40px;
        height: 40px;
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 16px;
    }
}

/* Animation */
.floating {
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* Lightbox styles */
.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    cursor: zoom-out;
}

.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
}

.lightbox-img {
    max-width: 100%;
    max-height: 90vh;
    object-fit: contain;
    border-radius: 4px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
}

.lightbox-close {
    position: absolute;
    top: -40px;
    right: 0;
    color: white;
    font-size: 30px;
    cursor: pointer;
}

@media (min-width: 1400px) {
    .pinterest-grid {
        column-count: 5;
        column-gap: 20px;
    }
    
    .pin-item {
        margin-bottom: 20px;
    }
}

@media (max-width: 1399px) and (min-width: 1200px) {
    .pinterest-grid {
        column-count: 4;
        column-gap: 18px;
    }
    
    .pin-item {
        margin-bottom: 18px;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid py-5 px-4">
    <!-- Hero Carousel -->
    <div class="hero-carousel" data-aos="fade-up">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img src="https://i.pinimg.com/originals/c2/2c/19/c22c19cc168d733849b69c70d19167f0.gif" alt="Featured Art 1">
                    <div class="slide-content">
                        <h2 class="slide-title">Selamat Datang di Artoverse</h2>
                        <p class="slide-text">Temukan dan bagikan kreasi seni dari seluruh dunia</p>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="https://i.pinimg.com/originals/8c/ff/0d/8cff0d9e985cfdba686aabd43032e40c.gif" alt="Featured Art 2">
                    <div class="slide-content">
                        <h2 class="slide-title">Eksplorasi Kreativitas</h2>
                        <p class="slide-text">Temukan inspirasi dari berbagai karya seni</p>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="https://i.pinimg.com/originals/4c/23/98/4c2398e6be397bb08b5cb70b2192d730.gif" alt="Featured Art 3">
                    <div class="slide-content">
                        <h2 class="slide-title">Bagikan Karyamu</h2>
                        <p class="slide-text">Jadilah bagian dari komunitas seni global</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-5 mt-4" data-aos="fade-up">
        <div>
            <h1 class="display-4 fw-bold mb-2" style="background: linear-gradient(45deg, var(--primary-color), #084298); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Artoverse
            </h1>
            <p class="text-muted lead" data-aos="fade-up" data-aos-delay="200">
                Jelajahi dunia seni dan kreativitas dalam satu platform
            </p>
        </div>
        <a href="{{ route('paintings.create') }}" class="btn btn-primary btn-lg floating">
            <i class="fas fa-plus"></i> Tambah Postingan
        </a>
    </div>

    <!-- Pinterest-style Masonry Grid -->
    <div class="pinterest-grid" id="masonry-grid" data-aos="fade-up">
        @foreach($paintings as $painting)
            <div class="pin-item" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                <div class="pin-img-container">
                    @if($painting->image)
                        <img src="{{ asset('storage/' . $painting->image) }}" class="pin-img" alt="{{ $painting->title }}">
                    @elseif($painting->image_url)
                        <img src="{{ $painting->image_url }}" class="pin-img" alt="{{ $painting->title }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center pin-img" style="height: 200px;">
                            <i class="fas fa-image text-muted fa-3x floating"></i>
                        </div>
                    @endif
                    
                    <div class="pin-overlay">
                        <!-- Hover overlay content -->
                    </div>
                    
                    <div class="pin-actions">
                        @auth
                            <form action="{{ route('paintings.like', $painting->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="pin-btn {{ $painting->isLikedBy(auth()->user()) ? 'like-active' : 'like' }}" title="{{ $painting->isLikedBy(auth()->user()) ? 'Hapus dari Favorit' : 'Tambahkan ke Favorit' }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                </form>
                        @endauth
                        <a href="{{ route('paintings.show', $painting->id) }}" class="pin-btn view" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(Auth::check() && (Auth::id() == $painting->user_id || Auth::user()->is_admin))
                        <a href="{{ route('paintings.edit', $painting->id) }}" class="pin-btn edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="pin-btn delete delete-btn" title="Hapus" 
                            data-id="{{ $painting->id }}" data-title="{{ $painting->title }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </div>
                </div>
                
                <div class="pin-content">
                    <h5 class="pin-title">{{ $painting->title }}</h5>
                </div>
            </div>
        @endforeach
    </div>
    
    <form id="delete-form" method="POST" style="display: none;">
        @csrf 
        @method('DELETE')
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    
    // Pinterest grid
    var grid = document.querySelector('.pinterest-grid');
    
    // Set optimal display for images based on their dimensions
    imagesLoaded(grid, function() {
        document.querySelectorAll('.pin-img').forEach(img => {
            // Only set dimensions if it's an actual image (not a placeholder)
            if (!img.classList.contains('bg-light')) {
                // Check image dimensions after loading
                img.onload = function() {
                    const width = this.naturalWidth;
                    const height = this.naturalHeight;
                    
                    // Determine if image is portrait or landscape
                    if (height > width) {
                        this.classList.add('portrait');
                        this.style.height = '400px';
                    } else {
                        this.classList.add('landscape');
                        this.style.height = '200px';
                    }
                    
                    this.style.objectFit = 'cover';
                };
                
                // Trigger onload if image is already loaded
                if (img.complete) {
                    img.onload();
                }
            }
        });
    });
    
    // Create lightbox element
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.innerHTML = `
        <div class="lightbox-content">
            <span class="lightbox-close">&times;</span>
            <img class="lightbox-img" src="" alt="Fullscreen image">
        </div>
    `;
    document.body.appendChild(lightbox);
    
    // Open lightbox on image click
    document.querySelectorAll('.pin-img-container').forEach(container => {
        container.addEventListener('click', function(e) {
            // Don't open lightbox if clicking on action buttons
            if (e.target.closest('.pin-actions') || e.target.closest('.pin-btn')) {
                return;
            }
            
            const img = this.querySelector('.pin-img');
            if (img && !img.classList.contains('bg-light')) {
                const src = img.getAttribute('src');
                const lightboxImg = document.querySelector('.lightbox-img');
                lightboxImg.setAttribute('src', src);
                lightbox.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Close lightbox
    lightbox.addEventListener('click', function() {
        this.style.display = 'none';
        document.body.style.overflow = 'auto';
    });
    
    document.querySelector('.lightbox-close').addEventListener('click', function() {
        lightbox.style.display = 'none';
        document.body.style.overflow = 'auto';
    });
    
    // Handle delete button clicks
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            
            if (confirm(`Apakah Anda yakin ingin menghapus lukisan "${title}"?`)) {
                const form = document.getElementById('delete-form');
                form.action = `/paintings/${id}`;
                form.submit();
            }
        });
    });
    
    // Keyboard navigation for lightbox
    document.addEventListener('keydown', function(e) {
        if (lightbox.style.display === 'flex') {
            if (e.key === 'Escape') {
                lightbox.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
    });
});
</script>
@endsection
