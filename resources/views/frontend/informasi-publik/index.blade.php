@extends('layouts.app')

@section('title', 'Informasi Publik - PPID')

@section('content')

{{-- ================= HEADER ================= --}}
<section class="py-5" style="background: linear-gradient(90deg, #0a3568 0%, #1f6fe5 100%); color: white;">
    <div class="container">
        <h1 class="fw-bold display-6 mb-2">Daftar Informasi Publik (DIP)</h1>
        <p class="fs-5 mb-0">
            Daftar lengkap seluruh dokumen Informasi Publik yang tersedia dan dapat diakses masyarakat
        </p>
    </div>
</section>

{{-- ================= KONTEN UTAMA ================= --}}
<section class="container py-5">

    {{-- KATEGORI INFORMASI --}}
    <div class="row g-4">

        {{-- Informasi Berkala --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-calendar-check text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Informasi Berkala</h5>
                    <p class="text-muted small mb-4">
                        Informasi yang wajib disediakan dan diumumkan secara berkala sekurang-kurangnya
                        setiap 6 (enam) bulan sekali.
                    </p>
                    <a href="{{ route('halaman-statis.show', 'informasi-berkala') }}"
                       class="btn btn-outline-primary btn-sm">
                        Lihat Dokumen <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Informasi Setiap Saat --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-clock-history text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Informasi Setiap Saat</h5>
                    <p class="text-muted small mb-4">
                        Informasi yang wajib tersedia setiap saat dan dapat diakses oleh publik
                        kapan pun dibutuhkan.
                    </p>
                    <a href="{{ route('halaman-statis.show', 'informasi-setiap-saat') }}"
                       class="btn btn-outline-success btn-sm">
                        Lihat Dokumen <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Informasi Serta-Merta --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-lightning-charge text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Informasi Serta-Merta</h5>
                    <p class="text-muted small mb-4">
                        Informasi yang wajib diumumkan segera kepada masyarakat apabila berpotensi
                        mengancam hajat hidup orang banyak.
                    </p>
                    <a href="{{ route('halaman-statis.show', 'informasi-serta-merta') }}"
                       class="btn btn-outline-warning btn-sm">
                        Lihat Dokumen <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= BANTUAN ================= --}}
    <div class="card mt-5 border-0 shadow-sm"
         style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center g-4">
                <div class="col-md-2 text-center">
                    <i class="bi bi-question-circle text-primary" style="font-size: 4rem;"></i>
                </div>
                <div class="col-md-10">
                    <h5 class="fw-bold mb-2">Butuh Bantuan?</h5>
                    <p class="mb-4">
                        Apabila Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut
                        terkait Informasi Publik, silakan hubungi kami melalui kanal berikut:
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://api.whatsapp.com/send/?phone=6285975062727&text&type=phone_number&app_absent=0"
                           target="_blank"
                           class="btn btn-primary">
                            <i class="bi bi-envelope me-2"></i>Hubungi Kami
                        </a>

                        <a href="{{ route('faq.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-question-circle me-2"></i>FAQ
                        </a>

                        <a href="{{ route('permohonan.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-file-earmark-text me-2"></i>Ajukan Permohonan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

{{-- ================= STYLE ================= --}}
<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,.15) !important;
}

.icon-wrapper {
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%,100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@media (max-width: 768px) {
    .card-body {
        padding: 2rem 1.5rem;
    }
}
</style>

@endsection
