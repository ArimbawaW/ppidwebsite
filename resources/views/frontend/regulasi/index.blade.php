@extends('layouts.app')

@section('title', 'Regulasi - PPID')

@section('content')

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-3">Regulasi</h1>
                <p class="text-white-50 mb-0 fs-5">
                    Kumpulan peraturan perundang-undangan yang menjadi dasar pelaksanaan PPID
                </p>
            </div>
            <div class="col-md-4 text-end">
                <i class="bi bi-file-earmark-text text-white" style="font-size: 120px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <form action="{{ route('regulasi.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <!-- Search Box -->
                <div class="col-md-4">
                    <label class="form-label fw-bold small">
                        <i class="bi bi-search me-1"></i>Cari Regulasi
                    </label>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari judul, nomor, atau deskripsi..."
                           value="{{ request('search') }}">
                </div>

                <!-- Filter Kategori -->
                <div class="col-md-3">
                    <label class="form-label fw-bold small">
                        <i class="bi bi-funnel me-1"></i>Kategori
                    </label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach(['Undang-Undang','Peraturan Pemerintah','Peraturan Menteri','Peraturan Daerah','Peraturan Presiden','Surat Edaran','Keputusan','Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div class="col-md-2">
                    <label class="form-label fw-bold small">
                        <i class="bi bi-calendar3 me-1"></i>Tahun
                    </label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @if(isset($tahuns))
                            @foreach($tahuns as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Cari
                        </button>
                        <a href="{{ route('regulasi.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Search Results Info -->
        @if(request()->hasAny(['search', 'kategori', 'tahun']))
        <div class="mt-3">
            <div class="alert alert-info mb-0 d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Hasil Pencarian:</strong> 
                    Ditemukan {{ $regulasi->total() }} regulasi
                    @if(request('search'))
                        untuk "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('kategori'))
                        dalam kategori <strong>{{ request('kategori') }}</strong>
                    @endif
                    @if(request('tahun'))
                        tahun <strong>{{ request('tahun') }}</strong>
                    @endif
                </div>
                <a href="{{ route('regulasi.index') }}" class="btn btn-sm btn-outline-info">
                    Lihat Semua
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($regulasi as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <!-- Badge Kategori -->
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $item->kategori ?? 'Regulasi' }}</span>
                            @if($item->tanggal_terbit)
                            <span class="badge bg-secondary">{{ $item->tanggal_terbit->format('Y') }}</span>
                            @endif
                        </div>

                        <!-- Nomor -->
                        @if($item->nomor)
                        <h6 class="text-muted mb-2">{{ $item->nomor }}</h6>
                        @endif

                        <!-- Judul -->
                        <h5 class="card-title fw-bold mb-3 title-clamp"
    title="{{ $item->judul }}">
    @if(request('search'))
        {!! Str::limit(
            str_ireplace(
                request('search'),
                '<mark>' . request('search') . '</mark>',
                $item->judul
            ),
            150
        ) !!}
    @else
        {{ Str::limit($item->judul, 150) }}
    @endif
</h5>


                        <!-- Deskripsi -->
                        @if($item->deskripsi)
                        <p class="card-text text-muted small">
                            {{ Str::limit($item->deskripsi, 100) }}
                        </p>
                        @endif

                        <!-- Tanggal -->
                        @if($item->tanggal_terbit)
                        <p class="text-muted small mb-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            Ditetapkan: {{ $item->tanggal_terbit->format('d F Y') }}
                        </p>
                        @endif
                    </div>
                    
                    <div class="card-footer bg-white border-0">
                        @if($item->file)
                        <a href="{{ asset('storage/' . $item->file) }}" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-download me-2"></i>Baca online
                        </a>
                        @else
                        <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                            <i class="bi bi-file-earmark-x me-2"></i>Dokumen Tidak Tersedia
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-search fs-1 d-block mb-3 text-muted"></i>
                    <h5 class="mb-2">Tidak Ada Hasil</h5>
                    <p class="mb-3">
                        @if(request()->hasAny(['search', 'kategori', 'tahun']))
                            Tidak ditemukan regulasi yang sesuai dengan pencarian Anda.
                        @else
                            Belum ada regulasi yang tersedia.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'kategori', 'tahun']))
                    <a href="{{ route('regulasi.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Pencarian
                    </a>
                    @endif
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($regulasi->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $regulasi->links() }}
            </div>
        </div>
        @endif
    </div>
</section>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

/* Highlight search results */
mark {
    background-color: #ffd700;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
}
.title-clamp {
    color: #1a6b8a;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

</style>

@endsection