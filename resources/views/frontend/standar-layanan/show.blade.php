@extends('layouts.app')

@section('title', $layanan->nama_layanan . ' - PPID')

@section('content')

<!-- ================= HEADER ================= -->
<section class="py-5" style="background:;">
    <div class="container">
        <h1 class="text-black fw-bold mb-2">
            {{ $layanan->nama_layanan }}
        </h1>

        @if($layanan->deskripsi)
            <p class="text-white-50 mb-0">
                {{ $layanan->deskripsi }}
            </p>
        @endif
    </div>
</section>
<!-- ========================================= -->

<!-- ================= KONTEN ================= -->
<section class="py-4">
    <div class="container">

        <!-- ===== TEKS ===== -->
        <div class="content-area mb-4" style="font-size: 16px; line-height: 1.8;">
            {!! nl2br(e($layanan->konten)) !!}
        </div>

        <!-- ===== GAMBAR INFOGRAFIS ===== -->
        @if($layanan->gambar)
        <div class="infografis-wrapper">
            <img 
                src="{{ asset('storage/' . $layanan->gambar) }}" 
                alt="{{ $layanan->nama_layanan }}" 
                class="infografis-image">
        </div>
        @endif

        <!-- ===== FILE ===== -->
        @if($layanan->file)
        <div class="mt-3">
            <a href="{{ asset('storage/' . $layanan->file) }}" 
               target="_blank" 
               class="btn btn-primary">
                <i class="bi bi-download me-2"></i>
                Unduh Dokumen Pendukung
            </a>
        </div>
        @endif

    </div>
</section>
<!-- ========================================= -->

<!-- ================= CSS ================= -->
<style>
/* Wrapper infografis */
.infografis-wrapper {
    width: 100%;
    max-width: 1200px;   /* mirip contoh Kemenkeu */
    margin: 0 auto 1.5rem;
    text-align: center;
}

/* Gambar besar, proporsional, tanpa crop */
.infografis-image {
    width: 100%;
    height: auto;
    max-height: none;

    display: block;
    margin: 0 auto;

    object-fit: contain;
}

/* Mobile */
@media (max-width: 768px) {
    .infografis-wrapper {
        max-width: 100%;
    }
}
</style>
<!-- ========================================= -->

@endsection
