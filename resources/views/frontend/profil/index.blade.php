@extends('layouts.app')

@section('title', 'Profil PPID')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="ppid-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Profil PPID</h1>
                <p class="text-white-50 mb-0">
                    Mengenal lebih dekat PPID Kementerian Perumahan dan Kawasan Permukiman
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-building text-white" style="font-size:64px; opacity:0.18;"></i>
            </div>
        </div>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<div class="container my-5">

    <!-- GAMBARAN SINGKAT -->
    <div class="row align-items-center g-4">

        <!-- LOGO -->
        <div class="col-md-6 text-center">
            <img src="{{ asset('images/rumah3.png') }}"
                 alt="Logo PPID"
                 style="width:100%; max-width:100%; height:auto; display:block; margin:0 auto;">
        </div>

        <!-- TEXT -->
        <div class="col-md-6">
            <div class="ppid-badge-wrap">
                <span class="ppid-badge">GAMBARAN SINGKAT</span>
            </div>
            <div class="ppid-body mt-4">
                <p>Dalam rangka mewujudkan keterbukaan informasi publik sebagaimana diamanatkan dalam Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik, Kementerian Perumahan dan Kawasan Permukiman berkomitmen untuk menyediakan layanan informasi yang transparan, akurat, dan dapat diakses oleh masyarakat.</p>
                <p>Sebagai bagian dari upaya tersebut, Kementerian Perumahan dan Kawasan Permukiman telah menetapkan pengelolaan layanan informasi publik melalui pembentukan Pejabat Pengelola Informasi dan Dokumentasi (PPID) sebagaimana ditetapkan dalam Surat Keputusan/SK Sekretaris Jenderal Kementerian PKP Nomor 02 Tahun 2026 tentang Penunjukan Pejabat Pengelola Informasi dan Dokumentasi di lingkungan Kementerian Perumahan dan Kawasan Permukiman.</p>
                <p>Keberadaan PPID di lingkungan Kementerian PKP menjadi bagian dari penguatan tata kelola layanan informasi publik yang mendukung penyelenggaraan kebijakan dan program pembangunan perumahan dan kawasan permukiman, termasuk program penyediaan hunian layak bagi masyarakat melalui berbagai kebijakan dan program strategis nasional.</p>
                <p>Melalui pengelolaan layanan informasi publik yang terstruktur dan berkelanjutan, Kementerian PKP terus berupaya meningkatkan kualitas keterbukaan informasi publik guna memperkuat kepercayaan masyarakat serta mendorong partisipasi publik dalam pembangunan sektor perumahan dan kawasan permukiman.</p>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <!-- PPID PKP -->
    <div>
        <div class="ppid-badge-wrap">
            <span class="ppid-badge">PPID KEMENTERIAN PERUMAHAN DAN KAWASAN PERMUKIMAN</span>
        </div>
        <div class="ppid-body mt-4">
            <p>Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kementerian Perumahan dan Kawasan Permukiman memiliki peran penting dalam mendukung transparansi, akuntabilitas, dan pelayanan publik, dengan memastikan bahwa informasi terkait kebijakan, program, serta kegiatan pembangunan infrastruktur dan perumahan dapat diakses dengan mudah oleh masyarakat. Selain itu, PPID juga bertugas untuk menjamin perlindungan terhadap informasi yang bersifat rahasia dan sensitif sesuai dengan peraturan perundang-undangan yang berlaku.</p>
        </div>

        <!-- MAP -->
        <div class="ratio ratio-16x9 rounded mt-4 shadow-sm">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1985112312714!2d106.7997384!3d-6.2375458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1004b01a95b%3A0xfaa45d1b19297f8c!2sKEMENTERIAN%20PKP!5e0!3m2!1sid!2sid!4v1764210011386!5m2!1sid!2sid"
                style="border:0; border-radius:12px;"
                allowfullscreen loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <!-- BERITA TERBARU -->
    <x-news-section :beritaTerbaru="$beritaTerbaru ?? collect()" />

</div>

<style>
.ppid-hero {
    position: relative;
    background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);
    overflow: hidden;
    min-height: 120px;
    padding: 32px 0;
    display: flex;
    align-items: center;
}
.ppid-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url('{{ asset("images/Pattern - Midnight Green.png") }}');
    background-size: 180px;
    background-repeat: repeat;
    mix-blend-mode: overlay;
    opacity: 0.35;
    pointer-events: none;
}

.ppid-badge-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: 8px;
}
.ppid-badge {
    display: inline-block;
    background-color: #c8b88a;
    color: #1a1a1a;
    font-weight: 800;
    font-size: 1.05rem;
    letter-spacing: 0.8px;
    padding: 12px 36px;
    border-radius: 50px;
    text-align: center;
    text-transform: uppercase;
    box-shadow: 0 2px 12px rgba(0,0,0,0.10);
}

.ppid-body {
    text-align: justify;
    line-height: 1.8;
    font-size: 0.95rem;
    color: #333;
}
.ppid-body p { margin-bottom: 1rem; }

@media (max-width: 768px) {
    .ppid-hero { padding: 24px 0; }
    .ppid-badge { font-size: 0.88rem; padding: 10px 22px; }
}
</style>

@endsection