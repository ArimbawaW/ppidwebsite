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
                        <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2">
                            <i class="bi bi-eye"></i> {{ number_format($berita->views) }}
                        </span>
                    </div>
                </div>
                @endif

                <div class="card-body">
                    <h5 class="fw-bold news-title">{{ $berita->judul }}</h5>
                    <p>{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                    <a href="{{ route('berita.show', $berita->slug) }}"
                       class="btn btn-sm btn-news">
                       Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .news-image-wrapper {
        overflow: hidden;
    }
    
    .news-card:hover .card-img-top {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    
    .card-img-top {
        transition: transform 0.3s ease;
    }
</style>
@endif