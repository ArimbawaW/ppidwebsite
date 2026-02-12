@extends('layouts.app')

@section('title', 'Maklumat - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Maklumat Pelayanan</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- GAMBAR MAKLUMAT --}}
            <img 
                src="{{ asset('images/maklumat.png') }}" 
                alt="Maklumat Pelayanan PPID"
                class="img-fluid mx-auto d-block maklumat-img"
            >

        </div>
    </div>

    <!-- Section Berita Terbaru -->
    <x-news-section :beritaTerbaru="$beritaTerbaru ?? collect()" />

</div>

<style>
    .maklumat-img {
        max-width: 100%;
        height: auto;
        width: 1200px;
    }
    
    /* Tablet */
    @media (max-width: 992px) {
        .maklumat-img {
            width: 100%;
        }
    }
    
    /* Mobile */
    @media (max-width: 576px) {
        .maklumat-img {
            width: 100%;
            max-width: 100%;
        }
    }
</style>
@endsection