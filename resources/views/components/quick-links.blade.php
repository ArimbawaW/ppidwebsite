<div class="mb-5">
    <div class="row g-4 justify-content-center">
        @php
            $links = [
                ['icon' => 'informasi.png', 'title' => 'Informasi Publik', 'route' => 'informasi-publik.index'],
                ['icon' => 'permohonan.png', 'title' => 'Permohonan', 'route' => 'permohonan.index'],
                ['icon' => 'cek.png', 'title' => 'Cek Permohonan', 'route' => 'permohonan.cek-status'],
                ['icon' => 'keberatan.png', 'title' => 'Keberatan', 'route' => 'keberatan.index'],
                ['icon' => 'cek2.png', 'title' => 'Cek Keberatan', 'route' => 'keberatan.cek'],
            ];
        @endphp

        @foreach($links as $link)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card quick-link-card shadow-sm border-0">
                    <img src="{{ asset('icons/' . $link['icon']) }}" alt="{{ $link['title'] }}">
                    <h5>{{ $link['title'] }}</h5>
                    <a href="{{ route($link['route']) }}" class="btn btn-quick-link">Lihat</a>
                </div>
            </div>
        @endforeach
    </div>
</div>