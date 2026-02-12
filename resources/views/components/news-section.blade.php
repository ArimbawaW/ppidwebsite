@if($beritaTerbaru->count() > 0)
<div class="my-5 pt-4">
    <h3 class="fw-bold mb-4 news-section-title">Berita Terbaru</h3>
    <div class="row g-4">
        @foreach($beritaTerbaru as $berita)
        <div class="col-md-4">
            <div class="card news-card h-100 border-0 shadow-sm">
                @if($berita->gambar)
                <div class="news-image-wrapper position-relative">
                    <img src="{{ asset('storage/' . $berita->gambar) }}"
                         class="card-img-top"
                         alt="{{ $berita->judul }}">
                    
                    <!-- Views Badge di pojok kanan bawah -->
                    <div class="position-absolute bottom-0 end-0 m-2">
                        <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-eye me-1"></i> {{ $berita->views }}
                        </span>
                    </div>
                </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="fw-bold news-title mb-3">{{ $berita->judul }}</h5>
                    
                    <!-- Tanggal di bawah judul -->
                    <p class="text-muted small mb-auto">
                        <i class="bi bi-calendar3"></i> 
                        {{ \Carbon\Carbon::parse($berita->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}
                    </p>
                    
                    <div class="mt-3">
                        <a href="{{ route('berita.show', $berita->slug) }}"
                           class="btn btn-news w-100">
                           Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
   
:root {
    --main-blue: #1A6B8A;
}

/* News Section Title */
.news-section-title {
    color: var(--main-blue);
    font-size: 1.75rem;
}

/* News Card Enhancement */
.news-card {
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
}

.news-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(26, 107, 138, 0.08),
        transparent
    );
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.news-card:hover::before {
    opacity: 1;
}

.news-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(26, 107, 138, 0.25);
}

.news-card .card-body {
    position: relative;
    z-index: 2;
}

/* News Image */
.news-image-wrapper {
    overflow: hidden;
    height: 220px;
    position: relative;
}

.news-image-wrapper img {
    height: 220px;
    object-fit: cover;
    width: 100%;
    transition: transform 0.5s ease;
}

.news-card:hover .news-image-wrapper img {
    transform: scale(1.1);
}

/* News Title */
.news-title {
    color: var(--main-blue);
    font-size: 1.1rem;
    line-height: 1.4;
    min-height: 2.8em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Button News */
.btn-news {
    background: var(--main-blue);
    color: #fff;
    border-radius: 25px;
    padding: 10px 24px;
    transition: all 0.3s ease;
    border: none;
    font-weight: 500;
}

.btn-news:hover {
    background: var(--main-blue);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(26, 107, 138, 0.35);
}

/* Views Badge */
.news-image-wrapper .badge {
    font-size: 0.85rem;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .news-image-wrapper {
        height: 200px;
    }

    .news-image-wrapper img {
        height: 200px;
    }

    .news-title {
        font-size: 1rem;
    }
}

</style>
@endif