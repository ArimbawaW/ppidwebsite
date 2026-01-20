@extends('layouts.app')

@section('title', 'Galeri - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center fw-bold">GALERI KEGIATAN</h2>
    
    <div class="row g-4">
        @forelse($galeri as $item)
        <div class="col-md-4 col-lg-3">
            <a href="{{ asset('storage/' . $item->gambar) }}" 
               class="glightbox" 
               data-gallery="gallery1"
               data-glightbox="title: {{ $item->judul }}; description: {{ $item->deskripsi ?? '' }}">
                <div class="galeri-item">
                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                         alt="{{ $item->judul }}"
                         class="img-fluid">
                    <div class="galeri-overlay">
                        <h6 class="mb-1">{{ $item->judul }}</h6>
                        @if($item->deskripsi)
                        <small>{{ Str::limit($item->deskripsi, 50) }}</small>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-md-12">
            <div class="alert alert-info text-center">Tidak ada galeri ditemukan.</div>
        </div>
        @endforelse
    </div>

    @if($galeri->hasPages())
    <div class="row mt-5">
        <div class="col-md-12 d-flex justify-content-center">
            {{ $galeri->links() }}
        </div>
    </div>
    @endif
</div>
@endsection