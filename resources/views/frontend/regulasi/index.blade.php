@extends('layouts.app')

@section('title', 'Regulasi - PPID')

@section('content')

<!-- ================= HERO SECTION (MASTER TEMPLATE) ================= -->
<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Regulasi</h1>
                <p class="text-white-50 mb-0">
                    Kumpulan peraturan perundang-undangan yang menjadi dasar pelaksanaan PPID
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-file-earmark-text text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

<!-- ================= FILTER SECTION ================= -->
<section class="filter-section">
    <div class="container">
        <form action="{{ route('regulasi.index') }}" method="GET">
            <div class="row g-3 align-items-end">

                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-search me-1"></i>Cari Regulasi
                    </label>
                    <input type="text" 
                        name="search" 
                        class="form-control form-control-sm" 
                        placeholder="Judul, nomor, atau deskripsi..."
                        value="{{ request('search') }}">
                </div>

                <!-- Kategori -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-funnel me-1"></i>Kategori
                    </label>
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach(['Undang-Undang','Peraturan Pemerintah','Peraturan Menteri','Peraturan Daerah','Peraturan Presiden','Surat Edaran','Keputusan','Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-calendar3 me-1"></i>Tahun
                    </label>
                    <select name="tahun" class="form-select form-select-sm">
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

                <!-- Button -->
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-search me-1"></i>Cari
                        </button>
                        <a href="{{ route('regulasi.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>

            </div>
        </form>

        <!-- Result Info -->
        @if(request()->hasAny(['search', 'kategori', 'tahun']))
        <div class="mt-3">
            <div class="alert alert-info compact-alert d-flex justify-content-between align-items-center">
                <div class="small">
                    <i class="bi bi-info-circle me-1"></i>
                    Ditemukan <strong>{{ $regulasi->total() }}</strong> regulasi
                    @if(request('search'))
                        untuk "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('kategori'))
                        | <strong>{{ request('kategori') }}</strong>
                    @endif
                    @if(request('tahun'))
                        | Tahun <strong>{{ request('tahun') }}</strong>
                    @endif
                </div>
                <a href="{{ route('regulasi.index') }}" class="btn btn-sm btn-outline-light">
                    Lihat Semua
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="content-section">
    <div class="container">
        <div class="row g-4">

            @forelse($regulasi as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card regulasi-card h-100 border-0 shadow-sm">

                    <div class="card-body">

                        <!-- Badges -->
                        <div class="mb-2">
                            <span class="badge badge-main">{{ $item->kategori ?? 'Regulasi' }}</span>
                            @if($item->tanggal_terbit)
                                <span class="badge badge-year">{{ $item->tanggal_terbit->format('Y') }}</span>
                            @endif
                        </div>

                        <!-- Nomor -->
                        @if($item->nomor)
                            <div class="small text-muted mb-1">{{ $item->nomor }}</div>
                        @endif

                        <!-- Judul -->
                        <h6 class="fw-bold regulasi-title mb-2"
                            title="{{ $item->judul }}">
                            @if(request('search'))
                                {!! Str::limit(
                                    str_ireplace(
                                        request('search'),
                                        '<mark>' . request('search') . '</mark>',
                                        $item->judul
                                    ),
                                    140
                                ) !!}
                            @else
                                {{ Str::limit($item->judul, 140) }}
                            @endif
                        </h6>

                        <!-- Deskripsi -->
                        @if($item->deskripsi)
                            <p class="small text-muted mb-2">
                                {{ Str::limit($item->deskripsi, 90) }}
                            </p>
                        @endif

                        <!-- Tanggal -->
                        @if($item->tanggal_terbit)
                            <div class="small text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $item->tanggal_terbit->format('d F Y') }}
                            </div>
                        @endif
                    </div>

                    <div class="card-footer bg-white border-0">
                        @if($item->file)
                            <a href="{{ asset('storage/' . $item->file) }}" 
                               target="_blank" 
                               class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-file-earmark-text me-2"></i>Baca Dokumen
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
                <div class="empty-state">
                    <i class="bi bi-search"></i>
                    <h6>Tidak Ada Data</h6>
                    <p>
                        @if(request()->hasAny(['search', 'kategori', 'tahun']))
                            Tidak ditemukan regulasi sesuai filter.
                        @else
                            Belum ada regulasi tersedia.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'kategori', 'tahun']))
                        <a href="{{ route('regulasi.index') }}" class="btn btn-primary btn-sm">
                            Reset Filter
                        </a>
                    @endif
                </div>
            </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if($regulasi->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $regulasi->links() }}
        </div>
        @endif
    </div>
</section>

{{-- ================= STYLES ================= --}}
<style>
:root{
    --main-blue:#1A6B8A;
}

/* ================= HERO ================= */
.hero-section{
    position:relative;
    background:linear-gradient(135deg,#1a6b8a 0%,#003344 100%);
    min-height:120px;
    padding:32px 0;
    display:flex;
    align-items:center;
    overflow:hidden;
    z-index:1;
}
.hero-section::before{
    content:"";
    position:absolute;
    inset:0;
    background-image:url('{{ asset("images/Pattern - Midnight Green.png") }}');
    background-size:180px;
    background-repeat:repeat;
    mix-blend-mode:overlay;
    opacity:.35;
    z-index:-1;
}
.hero-container{z-index:5;position:relative;}
.icon-hero{font-size:64px;opacity:.18}

/* ================= FILTER ================= */
.filter-section{
    background:#f6f9fb;
    padding:20px 0;
    border-bottom:1px solid #e5eef3;
}

/* ================= CONTENT ================= */
.content-section{
    padding:40px 0;
}

/* ================= CARD ================= */
.regulasi-card{
    border-radius:12px;
    transition:.3s ease;
}
.regulasi-card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 30px rgba(0,0,0,.12)!important;
}

/* ================= BADGES ================= */
.badge-main{
    background:var(--main-blue);
}
.badge-year{
    background:#6c757d;
}

/* ================= TITLE ================= */
.regulasi-title{
    color:var(--main-blue);
}

/* ================= BUTTON ================= */
.btn-primary{
    background:var(--main-blue);
    border-color:var(--main-blue);
}
.btn-outline-primary{
    color:var(--main-blue);
    border-color:var(--main-blue);
}
.btn-outline-primary:hover{
    background:var(--main-blue);
    color:#fff;
}

/* ================= ALERT ================= */
.alert-info{
    background:var(--main-blue);
    color:#fff;
    border:none;
}
.compact-alert{
    padding:.6rem .8rem;
    border-radius:8px;
}

/* ================= EMPTY ================= */
.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#6c757d;
}
.empty-state i{
    font-size:48px;
    opacity:.4;
    margin-bottom:10px;
}

/* ================= HIGHLIGHT ================= */
mark{
    background:#ffd700;
    padding:2px 4px;
    border-radius:3px;
    font-weight:600;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .hero-section{
        min-height:100px;
        padding:24px 0;
        text-align:center;
    }
    .icon-hero{display:none}
}
</style>

@endsection
