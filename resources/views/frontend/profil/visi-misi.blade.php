@extends('layouts.app')

@section('title', 'Visi-Misi - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Visi-Misi</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- GAMBAR visi --}}
            <img 
                src="{{ asset('images/visi.png') }}" 
                alt="Visi Misi PPID"
                class="img-fluid mx-auto d-block visi-img"
            >

        </div>
    </div>
</div>

<style>
    .visi-img {
        max-width: 100%;
        height: auto;
        width: 1200px;
    }
    
    /* Tablet */
    @media (max-width: 992px) {
        .visi-img {
            width: 100%;
        }
    }
    
    /* Mobile */
    @media (max-width: 576px) {
        .visi-img {
            width: 100%;
            max-width: 100%;
        }
    }
</style>
@endsection