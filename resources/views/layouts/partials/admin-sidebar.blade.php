<!-- ===== SIDEBAR ===== -->
<nav class="col-md-3 col-lg-2 d-md-block sidebar">

    {{-- Logo --}}
    <div class="logo-area">
        <img src="{{ asset('images/logoppid.png') }}" alt="Logo PPID">
    </div>

    {{-- Menu Title --}}
    <div class="menu-title">Menu</div>

    {{-- Navigation --}}
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
            <a class="nav-link {{ request()->routeIs('admin.informasi-publik.*') ? 'active' : '' }}"
               href="{{ route('admin.informasi-publik.index') }}">
                <i class="bi bi-info-circle"></i> Informasi Publik
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.halaman-statis.*') ? 'active' : '' }}"
               href="{{ route('admin.halaman-statis.index') }}">
                <i class="bi bi-file-earmark-text"></i> Halaman Statis
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

        {{-- REGULASI --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.regulasi.*') ? 'active' : '' }}"
               href="{{ route('admin.regulasi.index') }}">
                <i class="bi bi-book"></i> Regulasi
            </a>
        </li>

        {{-- STANDAR LAYANAN --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.standar-layanan.*') ? 'active' : '' }}"
               href="{{ route('admin.standar-layanan.index') }}">
                <i class="bi bi-clipboard-check"></i> Standar Layanan
            </a>
        </li>

        {{-- FAQ --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}"
               href="{{ route('admin.faq.index') }}">
                <i class="bi bi-question-circle"></i> FAQ
            </a>
        </li>

        {{-- Kembali ke Homepage --}}
        <li class="nav-item mt-3">
            <a class="nav-link homepage-link"
               href="{{ route('home') }}"
               target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Kembali ke Homepage
            </a>
        </li>

    </ul>
</nav>
