<!-- ===== SIDEBAR ===== -->
<nav class="col-md-3 col-lg-2 d-md-block sidebar">

    <div class="logo-area">
        <img src="<?php echo e(asset('build/assets/logoppid.png')); ?>" alt="Logo PPID">
    </div>

    <div class="menu-title">Menu</div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.permohonan.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.permohonan.index')); ?>">
                <i class="bi bi-envelope"></i> Permohonan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.keberatan.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.keberatan.index')); ?>">
                <i class="bi bi-exclamation-circle"></i> Keberatan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.berita.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.berita.index')); ?>">
                <i class="bi bi-newspaper"></i> Berita
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.informasi-publik.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.informasi-publik.index')); ?>">
                <i class="bi bi-info-circle"></i> Informasi Publik
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.halaman-statis.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.halaman-statis.index')); ?>">
                <i class="bi bi-file-earmark-text"></i> Halaman Statis
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.agenda-kegiatan.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.agenda-kegiatan.index')); ?>">
                <i class="bi bi-calendar-event"></i> Agenda Kegiatan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.galeri.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.galeri.index')); ?>">
                <i class="bi bi-images"></i> Galeri
            </a>
        </li>

        <!-- REGULASI (BARU) -->
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.regulasi.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.regulasi.index')); ?>">
                <i class="bi bi-file-earmark-text"></i> Regulasi
            </a>
        </li>

        <!-- STANDAR LAYANAN (BARU) -->
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.standar-layanan.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.standar-layanan.index')); ?>">
                <i class="bi bi-clipboard-check"></i> Standar Layanan
            </a>
        </li>

        <!-- FAQ (BARU) -->
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.faq.*') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.faq.index')); ?>">
                <i class="bi bi-question-circle"></i> FAQ
            </a>
        </li>

        
        <li class="nav-item">
            <a class="nav-link homepage-link" 
               href="<?php echo e(route('home')); ?>" 
               target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Kembali ke Homepage
            </a>
        </li>

    </ul>
</nav><?php /**PATH C:\ppid-website\resources\views/layouts/partials/admin-sidebar.blade.php ENDPATH**/ ?>