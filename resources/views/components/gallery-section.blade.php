@if($galeriTerbaru && $galeriTerbaru->count() > 0)
<div class="galeri-kegiatan-section">
    <div class="container-fluid">
        <h2 class="galeri-kegiatan-title">GALERI KEGIATAN</h2>
        
        <div class="galeri-slider">
            <button class="galeri-nav-btn prev" onclick="scrollGaleri(-1)">
                <i class="bi bi-chevron-left"></i>
            </button>
            
            <div class="galeri-slide-container" id="galeriSlider">
                @foreach($galeriTerbaru as $index => $galeri)
                <div class="galeri-slide-item" data-bs-toggle="modal" data-bs-target="#modalGaleriHome{{ $index }}" style="cursor: pointer;">
                    <div class="galeri-image-wrapper">
                        @if(isset($galeri->gambar) && $galeri->gambar)
                            <img src="{{ asset('storage/' . $galeri->gambar) }}" 
                                 alt="{{ $galeri->judul ?? 'Galeri' }}" 
                                 onerror="this.src='https://via.placeholder.com/400x350/3a7283/ffffff?text=Galeri+Kegiatan'">
                        @else
                            <img src="https://via.placeholder.com/400x350/3a7283/ffffff?text=Galeri+Kegiatan" 
                                 alt="Galeri Placeholder">
                        @endif
                        <div class="galeri-slide-overlay">
                            <h6>{{ $galeri->judul ?? 'Galeri Kegiatan' }}</h6>
                        </div>
                    </div>
                </div>

                <!-- Modal Fullscreen -->
                <div class="modal fade" id="modalGaleriHome{{ $index }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.95); border: none;">
                            <div class="modal-header border-0">
                                <h5 class="modal-title text-white">{{ $galeri->judul ?? 'Galeri Kegiatan' }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center p-0">
                                @if(isset($galeri->gambar) && $galeri->gambar)
                                    <img src="{{ asset('storage/' . $galeri->gambar) }}" 
                                         alt="{{ $galeri->judul ?? 'Galeri' }}"
                                         class="img-fluid"
                                         style="max-height: 85vh; width: auto; border-radius: 8px;">
                                @endif
                                @if(isset($galeri->deskripsi) && $galeri->deskripsi)
                                <div class="p-3">
                                    <p class="text-white mb-0">{{ $galeri->deskripsi }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <button class="galeri-nav-btn next" onclick="scrollGaleri(1)">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>


<style>
/* Ukuran card diperkecil */
.galeri-slide-item {
    position: relative;
    flex: 0 0 calc(20% - 10px); /* tampilkan lebih banyak item dalam satu baris */
    min-width: 220px;           /* sebelumnya 300px */
    height: 250px;              /* sebelumnya 350px */
    border-radius: 12px;
    border: 3px solid white;
    background: white;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    scroll-snap-align: start;
    padding: 3px;
}

/* Hover lebih halus */
.galeri-slide-item:hover {
    transform: scale(1.04);
    z-index: 10;
    box-shadow: 0 10px 28px rgba(0,0,0,0.35);
}

/* Wrapper gambar diperkecil */
.galeri-image-wrapper {
    width: 100%;
    height: 100%;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    background: #2d5a67;
}

/* Gambar tetap center dan cover */
.galeri-slide-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease-out;
}

.galeri-slide-item:hover img {
    transform: scale(1.08);
}

/* Overlay judul diperkecil */
.galeri-slide-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75), transparent);
    color: white;
    padding: 10px;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.galeri-slide-item:hover .galeri-slide-overlay {
    opacity: 1;
}

.galeri-slide-overlay h6 {
    margin: 0;
    font-size: 12px;
    font-weight: 600;
}
</style>


@else
<div class="galeri-kegiatan-section">
    <div class="container-fluid">
        <h2 class="galeri-kegiatan-title">GALERI KEGIATAN</h2>
        
        <div class="galeri-slider">
            <button class="galeri-nav-btn prev" onclick="scrollGaleri(-1)">
                <i class="bi bi-chevron-left"></i>
            </button>
            
            <div class="galeri-slide-container" id="galeriSlider">
                @for($i = 1; $i <= 8; $i++)
                <div class="galeri-slide-item">
                    <div class="galeri-image-wrapper">
                        <img src="https://via.placeholder.com/400x350/3a7283/ffffff?text=Galeri+{{ $i }}" 
                             alt="Galeri Placeholder {{ $i }}">
                    </div>
                </div>
                @endfor
            </div>
            
            <button class="galeri-nav-btn next" onclick="scrollGaleri(1)">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
        
        <div class="text-center mt-4">
            <p class="galeri-empty-message">
                <i class="bi bi-info-circle me-2"></i>
                Belum ada galeri kegiatan yang tersedia
            </p>
        </div>
    </div>
</div>
@endif