

<?php $__env->startSection('title', 'Profil PPID'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .header-banner {
        background: #0B638A;
        color: white;
        padding: 40px 0;
        border-radius: 15px;
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 40px;
    }
    .profile-section img {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .profile-title {
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 15px;
    }
</style>

<div class="container my-5">

    <!-- Header Banner -->
    <div class="header-banner">
        Profil PPID
    </div>

    <div class="row profile-section">

        <!-- FOTO -->
        <div class="col-md-6">
            <img src="<?php echo e(asset('images/rumah.png')); ?>" alt="Foto Perumahan">
        </div>

        <!-- Latar Belakang -->
        <div class="col-md-6">
            <div class="profile-title">LATAR BELAKANG</div>
            <p>
                Dalam rangka mewujudkan penyelenggaraan Pelayanan Publik Terpadu sesuai dengan asas 
                penyelenggaraan pemerintahan yang baik, mewujudkan kepastian hak dan kewajiban berbagai pihak 
                yang berkaitan dengan penyelenggaraan pelayanan, menjamin dan meningkatkan kualitas pelayanan 
                publik agar disiplin serta mencegah terjadinya perbuatan yang dapat mengarah pada pelanggaran 
                disiplin dan pelanggaran hukum, setiap penyelenggara pelayanan publik terpadu wajib menetapkan 
                standar pelayanan publik terpadu.
            </p>

            <p>
                Kementerian Perumahan dan Kawasan Permukiman perlu menggiatkan penerapan nilai pelayanan publik 
                terpadu sesuai dengan asas-asas umum pemerintahan yang baik sehingga dapat memberi perlindungan 
                bagi setiap masyarakat dari penyalahgunaan wewenang di dalam penyelenggaraan pelayanan publik terpadu.
            </p>

            <p>
                Oleh karena itu, untuk melaksanakan pelayanan informasi maka dibentuklah Pejabat Pengelola 
                Informasi dan Dokumentasi (PPID) yang bertanggung jawab memberikan pelayanan informasi yang 
                meliputi proses penyimpanan, pendokumentasian, dan penyediaan pelayanan serta pengumuman informasi publik.
            </p>
        </div>
    </div>

    <hr class="my-5">

    <!-- PPID KEMENTERIAN PKP -->
    <div class="mt-4">
        <div class="profile-title">PPID KEMENTERIAN PERUMAHAN DAN KAWASAN PERMUKIMAN</div>
        <p>
            Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kementerian Perumahan dan Kawasan Permukiman 
            memiliki peran penting dalam mendukung transparansi, akuntabilitas, dan pelayanan publik, dengan 
            memastikan bahwa informasi terkait kebijakan, program, serta kegiatan pembangunan infrastruktur 
            dan perumahan dapat diakses dengan mudah oleh masyarakat. Selain itu, PPID juga bertugas untuk 
            menjamin perlindungan terhadap informasi yang bersifat rahasia dan sensitif sesuai dengan peraturan
            perundang-undangan yang berlaku.
        </p>

        <!-- MAP -->
       <div class="ratio ratio-16x9 rounded mt-4">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1985112312714!2d106.7997384!3d-6.2375458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1004b01a95b%3A0xfaa45d1b19297f8c!2sKEMENTERIAN%20PKP!5e0!3m2!1sid!2sid!4v1764210011386!5m2!1sid!2sid" 
        style="border:0; border-radius: 12px;" 
        allowfullscreen 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/profil/index.blade.php ENDPATH**/ ?>