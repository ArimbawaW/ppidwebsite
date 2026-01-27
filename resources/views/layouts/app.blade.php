<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPID Website')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LogoPKP.png') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/agenda.css') }}">    

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>

/* =========================================================
   NAVBAR CUSTOM - WARNA UTAMA
   ========================================================= */

.navbar-custom {
    background-color: #1a6b8a;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
}

.navbar-custom::after {
    background: #d5c58a; /* aksen emas tetap */
}

/* Brand text */
.navbar-custom .navbar-brand div:first-child {
    color: #ffffff !important;
}

.navbar-custom .navbar-brand div:last-child {
    color: #e6f4f8 !important;
}


/* Nav links */
.navbar-custom .nav-link {
    color: #ffffff !important;
    font-weight: 600;
}

.navbar-custom .nav-link:hover {
    background: #d5c58a !important;
    color: #1a6b8a !important;
}

.navbar-custom .nav-link.active {
    background: #d5c58a !important;
    color: #1a6b8a !important;
}

/* Dropdown */
.navbar-custom .dropdown-menu {
    border-radius: 10px;
    border: none;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.navbar-custom .dropdown-item {
    font-weight: 600;
}

.navbar-custom .dropdown-item:hover {
    background: #1a6b8a;
    color: #ffffff;
}


/* Toggler */
.navbar-custom .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.6);
}

.navbar-custom .navbar-toggler-icon {
    filter: invert(1);
}

        /* ==== STICKY FOOTER ==== */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        footer {
            margin-top: auto;
        }
        /* ==== END STICKY FOOTER ==== */

        body, * {
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600;
        }

        .navbar-brand {
            font-weight: 800 !important;
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        /* Agar navbar tidak menempel kiri */
        .navbar {
            padding-left: 0 !important;
            padding-right: 0 !important;
            position: relative;
        }

        .navbar .container-fluid {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }

        .navbar::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #d5c58a;
        }

        /* Logo tanpa margin berlebih */
        .navbar-brand img {
            margin-left: 0 !important;
        }

        /* Nav link styling */
        .nav-link {
            color: #1a6b8a !important;
            padding: 6px 14px !important;
            margin: 0 2px;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .navbar-custom .nav-link:hover {
        background: #ffffff !important;
         color: #1a6b8a !important;
        }

        .navbar-custom .nav-link.active {
        background: #ffffff !important;
        color: #1a6b8a !important;
        }

        /* === GALERI LIGHTBOX STYLE === */
        .galeri-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .galeri-item:hover {
            transform: scale(1.05);
        }

        .galeri-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .galeri-item:hover img {
            transform: scale(1.1);
        }

        .galeri-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            padding: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .galeri-item:hover .galeri-overlay {
            opacity: 1;
        }

        /* Custom GLightbox styling */
        .glightbox-clean .gslide-description {
            background: rgba(0, 0, 0, 0.75);
            padding: 15px 20px;
        }

        /* Logo tanpa margin berlebih */
        .navbar-brand img {
            margin-left: 0 !important;
        }

        .ppid-link,
        .ppid-link:hover,
        .ppid-link:focus,
        .ppid-link:active {
            text-decoration: none !important;
            color: inherit !important;
        }

        /* =========================================================
           FIX TOMBOL NAVBAR MENU SELALU DI KANAN (MOBILE)
           ========================================================= */
        
        /* Desktop - tetap seperti semula */
        @media (min-width: 992px) {
            .navbar-toggler {
                display: none;
            }
        }

        /* Mobile - tombol navbar di kanan */
        @media (max-width: 991.98px) {
            /* Pastikan container-fluid menggunakan flexbox */
            .navbar .container-fluid {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            /* Logo tetap di kiri */
            .navbar-brand {
                order: 1;
                flex-shrink: 0;
            }

            /* Tombol toggler di kanan */
            .navbar-toggler {
                order: 3;
                margin-left: auto;
                border: none !important;
                box-shadow: none !important;
                outline: none !important;
                padding: 6px 10px;
                position: absolute;
                top: 12px;
                right: 12px;
                z-index: 1051;
            }

            /* Menu collapse di bawah */
            .navbar-collapse {
                order: 4;
                width: 100%;
                flex-basis: 100%;
                margin-top: 4px;
            }

            /* Padding untuk menu items */
            .navbar-nav {
                margin-top: 12px;
            }

            .navbar-nav .nav-item {
                margin-bottom: 6px;
            }

            .navbar-nav .nav-link {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            /* Dropdown menu */
            .dropdown-menu {
                margin-left: 12px;
                margin-right: 12px;
            }

            .navbar-brand {
                padding-right: 56px;
            }

            /* Responsive text size */
            .navbar-brand > div > div:first-child {
                font-size: 18px !important;
            }
            
            .navbar-brand > div > div:last-child {
                font-size: 9px !important;
            }
            
            .navbar-brand img {
                height: 40px !important;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand > div > div:first-child {
                font-size: 16px !important;
            }
            
            .navbar-brand > div > div:last-child {
                font-size: 8px !important;
            }
            
            .navbar-brand img {
                height: 35px !important;
                margin-right: 8px !important;
            }
        }

        /* =========================================================
           FOOTER STYLES - REDESIGN
           ========================================================= */
        
        footer {
            background: linear-gradient(135deg, #0a4a5a 0%, #0d5a6d 100%);
            padding: 0;
            position: relative;
        }

        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #d5c58a;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        /* Logo Section */
        .footer-logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .footer-logo-section img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .footer-logo-section img:hover {
            transform: scale(1.05);
        }

        .footer-brand-text h2 {
            font-size: 26px;
            font-weight: 800;
            color: white;
            margin: 0 0 3px 0;
            line-height: 1;
        }

        .footer-brand-text p {
            font-size: 10px;
            font-weight: 600;
            color: white;
            margin: 0;
            line-height: 1.3;
            text-transform: uppercase;
        }

        /* Address Section */
        .footer-address {
            text-align: center;
            color: white;
        }

        .footer-address h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: white;
        }

        .footer-address p {
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            margin: 0 0 20px 0;
            color: rgba(255, 255, 255, 0.95);
        }

        /* Visitor Counter */
        .visitor-counter {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 25px;
            padding: 8px 18px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .visitor-counter:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-2px);
        }

        .visitor-icon {
            font-size: 18px;
            color: #d5c58a;
        }

        .visitor-label {
            font-size: 12px;
            font-weight: 600;
            color: white;
        }

        .visitor-count {
            font-size: 16px;
            font-weight: 800;
            color: #d5c58a;
        }

        /* Contact Section */
        .footer-contact {
            text-align: right;
            color: white;
        }

        .footer-contact h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: white;
        }

        .whatsapp-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .whatsapp-link:hover {
            color: #d5c58a;
            transform: translateX(-5px);
        }

        .whatsapp-link i {
            font-size: 24px;
        }

        /* Social Media */
        .social-media {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .social-link {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-link:hover {
            background: white;
            color: #0a4a5a;
            transform: translateY(-5px);
        }

        /* Mobile Responsive Footer */
        @media (max-width: 992px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
                text-align: center;
            }

            .footer-container {
                padding: 25px 20px;
            }

            .footer-logo-section {
                justify-content: center;
            }

            .footer-address {
                text-align: center;
            }

            .footer-contact {
                text-align: center;
            }

            .whatsapp-link {
                justify-content: center;
            }

            .social-media {
                justify-content: center;
            }

            .footer-brand-text h2 {
                font-size: 22px;
            }

            .footer-logo-section img {
                width: 60px;
                height: 60px;
            }
        }

        @media (max-width: 576px) {
            .footer-container {
                padding: 20px 15px;
            }

            .footer-grid {
                gap: 25px;
            }

            .footer-logo-section {
                gap: 12px;
            }

            .footer-brand-text h2 {
                font-size: 20px;
            }

            .footer-brand-text p {
                font-size: 9px;
            }

            .footer-address h3,
            .footer-contact h3 {
                font-size: 16px;
                margin-bottom: 10px;
            }

            .footer-address p {
                font-size: 12px;
                margin-bottom: 15px;
            }

            .visitor-counter {
                padding: 6px 14px;
            }

            .visitor-icon {
                font-size: 16px;
            }

            .visitor-label {
                font-size: 11px;
            }

            .visitor-count {
                font-size: 14px;
            }

            .whatsapp-link {
                font-size: 14px;
                margin-bottom: 12px;
            }

            .whatsapp-link i {
                font-size: 20px;
            }

            .social-link {
                width: 35px;
                height: 35px;
                font-size: 16px;
            }

            .social-media {
                gap: 10px;
            }
        }
    @media (min-width: 992px) {
    .navbar-custom .container-fluid {
        padding-left: 48px !important;
    }
}
@media (min-width: 992px) {
    .navbar-custom .navbar-brand img {
        height: 56px !important;
        width: auto;
    }

    .navbar-custom .navbar-brand .brand-title {
        font-size: 22px;
        line-height: 1.1;
        font-weight: 800;
    }

    .navbar-custom .navbar-brand .brand-subtitle {
        font-size: 11px;
        line-height: 1.3;
        font-weight: 700;
    }
}
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">

            <!-- LOGO + TEKS -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/LogoPKP.png') }}" alt="Logo PKP" height="50" class="me-3">
                <div>
                    <div style="font-size: 22px; line-height: 1.2; font-weight: 800; color: #d5c58a;">
                        PPID
                    </div>
                    <div style="font-size: 11px; font-weight: 700; line-height: 1.2; color: #1a6b8a; margin-top: 2px;">
                        KEMENTERIAN PERUMAHAN DAN KAWASAN PERMUKIMAN
                    </div>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: #1a6b8a;">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- Beranda -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">
                            Beranda
                        </a>
                    </li>

                    <!-- Profil PPID -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('profil.*') ? 'active' : '' }}" 
                           href="#" 
                           id="profilDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown">
                            Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profil.index') }}">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil.struktur-organisasi') }}">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil.tugas-fungsi') }}">Tugas & Fungsi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil.visi-misi') }}">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('profil.dasar-hukum') }}">Maklumat</a></li>
                        </ul>
                    </li>

                    <!-- Regulasi -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('regulasi.*') ? 'active' : '' }}" 
                           href="{{ route('regulasi.index') }}">
                            Regulasi
                        </a>
                    </li>

                    <!-- Informasi Publik -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('informasi-publik.*') || request()->routeIs('halaman-statis.*') ? 'active' : '' }}" 
                           href="#" 
                           role="button" 
                           data-bs-toggle="dropdown">
                            Informasi Publik
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('halaman-statis.show', 'informasi-berkala') }}">Informasi Berkala</a></li>
                            <li><a class="dropdown-item" href="{{ route('halaman-statis.show', 'informasi-serta-merta') }}">Informasi Serta-Merta</a></li>
                            <li><a class="dropdown-item" href="{{ route('halaman-statis.show', 'informasi-setiap-saat') }}">Informasi Setiap Saat</a></li>
                        </ul>
                    </li>

                    <!-- Standar Layanan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('standar-layanan.*') ? 'active' : '' }}" 
                           href="#" 
                           role="button" 
                           data-bs-toggle="dropdown">
                            Standar Layanan
                        </a>
                        <ul class="dropdown-menu">
                            @php
                                $standarLayananMenu = \App\Models\StandarLayanan::where('is_active', true)
                                    ->orderBy('urutan')
                                    ->get();
                            @endphp
                            
                            @forelse($standarLayananMenu as $menu)
                                <li>
                                    <a class="dropdown-item" href="{{ route('standar-layanan.show', $menu->slug) }}">
                                        {{ $menu->nama_layanan }}
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item text-muted">Belum ada halaman</span></li>
                            @endforelse
                        </ul>
                    </li>

                    <!-- FAQ -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('faq.*') ? 'active' : '' }}" 
                           href="{{ route('faq.index') }}">
                            FAQ
                        </a>
                    </li>

                    <!-- Berita -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}" 
                           href="{{ route('berita.index') }}">
                            Berita
                        </a>
                    </li>

                    <!-- Galeri -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri.*') ? 'active' : '' }}" 
                           href="{{ route('galeri.index') }}">
                            Galeri
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

  <footer>
        <div class="footer-container">
            <div class="footer-grid">
                
                <div class="footer-logo-section">
                    <img src="{{ asset('images/LogoPKP.png') }}" alt="Logo PKP">
                    <div class="footer-brand-text">
                        <h2>PPID</h2>
                        <p>
                            KEMENTERIAN PERUMAHAN<br>
                            DAN KAWASAN PERMUKIMAN<br>
                            REPUBLIK INDONESIA
                        </p>
                    </div>
                </div>

                <div class="footer-address">
                    <h3>Alamat</h3>
                    <p>
                        Jl. Raden Patah 1, Selong,<br>
                        Kebayoran Baru, Jakarta Selatan
                    </p>
                    
                    <div class="visitor-counter">
                        <i class="bi bi-eye visitor-icon"></i>
                        <span class="visitor-label">Total Pengunjung:</span>
                        <span class="visitor-count">
                            @php
                                try {
                                    $totalVisitors = \App\Models\Visitor::getTotalVisitors();
                                } catch (\Exception $e) {
                                    $totalVisitors = 0;
                                }
                            @endphp
                            {{ number_format($totalVisitors, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="footer-contact">
                    <h3>Hubungi Kami:</h3>
                    
                    <a href="https://wa.me/6285975062727" target="_blank" class="whatsapp-link">
                        <i class="bi bi-whatsapp"></i>
                        <span>0859 7506 2727</span>
                    </a>

                    <div class="social-media">
                        <a href="https://pkp.go.id" target="_blank" class="social-link" title="Website">
                            <i class="bi bi-globe"></i>
                        </a>
                        <a href="https://www.instagram.com/ppid.kemenpkp/" target="_blank" class="social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@KementerianPKP" target="_blank" class="social-link" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        </div>
                </div>

            </div>
        </div>
    </footer>

    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        // Initialize GLightbox
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,<nav class="navbar navbar-expand-lg navbar-custom">
            autoplayVideos: true,
            closeButton: true,
            zoomable: true,
            draggable: true
        });
    </script>

    @stack('scripts')
</body>
</html>