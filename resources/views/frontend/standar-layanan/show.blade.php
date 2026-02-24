@extends('layouts.app')

@section('title', $layanan->nama_layanan . ' - PPID')

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">
                    {{ $layanan->nama_layanan }}
                </h1>
                @if($layanan->deskripsi)
                    <p class="text-white-50 mb-0">
                        {{ $layanan->deskripsi }}
                    </p>
                @endif
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-clipboard-check icon-hero"></i>
            </div>
        </div>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- BLOK 1: Gambar 1 -> Deskripsi 1 --}}
                @if($layanan->gambar)
                    <div class="text-center mb-4">
                        <img
                            src="{{ asset('storage/' . $layanan->gambar) }}"
                            alt="{{ $layanan->nama_layanan }}"
                            class="infografis-image shadow-sm border rounded">
                    </div>
                @endif

                <div class="content-area mb-5">
                    {{-- Gunakan {!! !!} saja karena data dari CKEditor sudah aman berbentuk HTML --}}
                    {!! $layanan->konten !!}
                </div>

                {{-- Box unduhan file (opsional) --}}
                @if($layanan->file)
                    <div class="download-box p-4 bg-light border rounded-3 d-flex align-items-center justify-content-between mb-5">
                        <div>
                            <h6 class="mb-1 fw-bold">Dokumen Pendukung</h6>
                            <p class="text-muted small mb-0">Silakan unduh dokumen terkait layanan ini di sini.</p>
                        </div>
                        <a href="{{ asset('storage/' . $layanan->file) }}"
                           target="_blank"
                           class="btn btn-primary px-4">
                            <i class="bi bi-download me-2"></i>
                            Unduh Dokumen
                        </a>
                    </div>
                @endif

                {{-- Pemisah Visual Jika Ada Blok Kedua --}}
                @if($layanan->gambar_2 || $layanan->deskripsi_2)
                    <hr class="my-5" style="opacity: 0.1;">
                @endif

                {{-- BLOK 2: Gambar 2 -> Deskripsi 2 --}}
                @if($layanan->gambar_2)
                    <div class="text-center mb-4">
                        <img
                            src="{{ asset('storage/' . $layanan->gambar_2) }}"
                            alt="{{ $layanan->nama_layanan }} - Infografis Tambahan"
                            class="infografis-image shadow-sm border rounded">
                    </div>
                @endif

                @if($layanan->deskripsi_2)
                    <div class="content-area mb-5">
                        {!! $layanan->deskripsi_2 !!}
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
:root {
    --main-blue: #1A6B8A;
    --dark-blue: #003344;
    --text: #334155;
}

/* ================= HERO ================= */
.hero-section {
    position: relative;
    background: linear-gradient(135deg, var(--main-blue) 0%, var(--dark-blue) 100%);
    min-height: 120px;
    padding: 32px 0;
    display: flex;
    align-items: center;
    overflow: hidden;
    z-index: 1;
}

.hero-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url('{{ asset("images/Pattern - Midnight Green.png") }}');
    background-size: 180px;
    background-repeat: repeat;
    mix-blend-mode: overlay;
    opacity: 0.35;
    z-index: -1;
    pointer-events: none;
}

.hero-container {
    position: relative;
    z-index: 5;
}

.icon-hero {
    font-size: 64px;
    opacity: 0.18;
    color: #fff;
}

/* ================= CONTENT ================= */
.content-area {
    font-size: 17px;
    line-height: 1.8;
    color: var(--text);
}

/* Memastikan konten dari CKEditor tampil rapi */
.content-area p { margin-bottom: 1.2rem; }
.content-area ul, .content-area ol { margin-bottom: 1.2rem; padding-left: 20px; }
.content-area strong { color: #000; font-weight: 700; }

.infografis-image {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
}

.btn-primary {
    background-color: var(--main-blue) !important;
    border-color: var(--main-blue) !important;
}

.btn-primary:hover {
    background-color: var(--dark-blue) !important;
    box-shadow: 0 4px 12px rgba(26, 107, 138, 0.2);
}

.download-box {
    border-left: 5px solid var(--main-blue) !important;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .hero-section {
        min-height: 100px;
        padding: 24px 0;
        text-align: center;
    }
    .icon-hero { display: none; }
    .download-box {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
}
</style>
@endpush