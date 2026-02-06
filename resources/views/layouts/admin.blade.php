<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - PPID')</title>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Admin Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    @stack('styles')
</head>
<body>

<div class="container-fluid">
    <div class="row">

        {{-- ============================================
             NAVBAR MOBILE (HANYA MUNCUL DI HP)
             ============================================ --}}
        <nav class="navbar navbar-dark d-md-none" style="background-color:#003f54;">
            <div class="container-fluid">
                <span class="navbar-brand">Admin Panel</span>
                <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#sidebarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        {{-- ============================================
             SIDEBAR
             ============================================ --}}
        <nav id="sidebarMenu"
             class="col-md-3 col-lg-2 d-md-block sidebar collapse">

            {{-- Logo Area --}}
            <div class="logo-area">
                <img src="{{ asset('images/logoppid.png') }}" alt="Logo PPID">
            </div>

            <div class="menu-title">Menu Utama</div>

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.permohonan.*') ? 'active' : '' }}"
                       href="{{ route('admin.permohonan.index') }}">
                        <i class="bi bi-envelope"></i> Permohonan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.keberatan.*') ? 'active' : '' }}"
                       href="{{ route('admin.keberatan.index') }}">
                        <i class="bi bi-exclamation-circle"></i> Keberatan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"
                       href="{{ route('admin.berita.index') }}">
                        <i class="bi bi-newspaper"></i> Berita
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.banner-slider.*') ? 'active' : '' }}"
                       href="{{ route('admin.banner-slider.index') }}">
                        <i class="bi bi-images"></i> Banner Slider
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.halaman-statis.*') ? 'active' : '' }}"
                       href="{{ route('admin.halaman-statis.index') }}">
                        <i class="bi bi-file-earmark-text"></i> Informasi Publik
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.agenda-kegiatan.*') ? 'active' : '' }}"
                       href="{{ route('admin.agenda-kegiatan.index') }}">
                        <i class="bi bi-calendar-event"></i> Agenda Kegiatan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}"
                       href="{{ route('admin.galeri.index') }}">
                        <i class="bi bi-images"></i> Galeri
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.regulasi.*') ? 'active' : '' }}"
                       href="{{ route('admin.regulasi.index') }}">
                        <i class="bi bi-book"></i> Regulasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.standar-layanan.*') ? 'active' : '' }}"
                       href="{{ route('admin.standar-layanan.index') }}">
                        <i class="bi bi-clipboard-check"></i> Standar Layanan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}"
                       href="{{ route('admin.faq.index') }}">
                        <i class="bi bi-question-circle"></i> FAQ
                    </a>
                </li>

                <div class="menu-title mt-3">Lainnya</div>

                <li class="nav-item">
                    <a class="nav-link homepage-link"
                       href="{{ route('home') }}"
                       target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> Lihat Website
                    </a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="nav-link text-start w-100 border-0 bg-transparent">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </nav>

        {{-- ============================================
             MAIN CONTENT
             ============================================ --}}
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @yield('content')
        </main>

    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

{{-- Bootstrap JS Bundle (TAMBAHAN UNTUK MODAL & COMPONENTS) --}}
{{-- Pastikan ini di-load setelah jQuery dan sebelum @stack('scripts') --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>