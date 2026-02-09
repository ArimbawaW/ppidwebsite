@extends('layouts.app')

@section('title', 'Struktur Organisasi - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Struktur Organisasi</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- GAMBAR Struktur --}}
            <img 
                src="{{ asset('images/struktur2.png') }}" 
                alt="Tugas dan Fungsi PPID"
                class="img-fluid mx-auto d-block struktur-img"
            >

        </div>
    </div>
</div>

<style>
    .struktur-img {
        max-width: 100%;
        height: auto;
        width: 1200px;
    }
    
    /* Tablet */
    @media (max-width: 992px) {
        .struktur-img {
            width: 100%;
        }
    }
    
    /* Mobile */
    @media (max-width: 576px) {
        .struktur-img {
            width: 100%;
            max-width: 100%;
        }
    }
</style>
@endsection