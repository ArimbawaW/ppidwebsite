@extends('layouts.app')

@section('title', 'Berita - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Berita & Artikel</h2>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('berita.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="berita" {{ request('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="artikel" {{ request('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                        <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($berita as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($item->gambar)
                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <span class="badge bg-secondary mb-2">{{ ucfirst($item->kategori) }}</span>
                    <h5 class="card-title">{{ $item->judul }}</h5>
                    <p class="card-text">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                    <p class="card-text">
                        <small class="text-muted">{{ $item->created_at->format('d M Y') }} | {{ $item->views }} views</small>
                    </p>
                    <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-md-12">
            <div class="alert alert-info">Tidak ada berita ditemukan.</div>
        </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            {{ $berita->links() }}
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --main-blue: #1A6B8A;
}

/* Buttons */
.btn-primary,
.btn-sm.btn-primary {
    background-color: var(--main-blue) !important;
    border-color: var(--main-blue) !important;
    color: #fff !important;
}

.btn-primary:hover,
.btn-sm.btn-primary:hover {
    background-color: var(--main-blue) !important;
    border-color: var(--main-blue) !important;
    color: #fff !important;
    box-shadow: 0 6px 16px rgba(26, 107, 138, 0.35);
}

/* Alerts */
.alert-info {
    background-color: var(--main-blue) !important;
    border-color: var(--main-blue) !important;
    color: #fff !important;
}

/* Text */
.text-primary,
.text-info {
    color: var(--main-blue) !important;
}

/* Pagination */
.page-link {
    color: var(--main-blue) !important;
}
.page-item.active .page-link {
    background-color: var(--main-blue) !important;
    border-color: var(--main-blue) !important;
    color: #fff !important;
}

/* Badges (primary only, secondary tetap netral) */
.badge.bg-primary {
    background-color: var(--main-blue) !important;
}

/* Search button width consistency */
form .btn {
    font-weight: 500;
}
</style>
