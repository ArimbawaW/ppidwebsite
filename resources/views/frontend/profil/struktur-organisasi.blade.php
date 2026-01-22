@extends('layouts.app')

@section('title', 'Struktur Organisasi - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Struktur Organisasi</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- GAMBAR Struktur --}}
            <img 
                src="{{ asset('images/struktur.png') }}" 
                alt="Tugas dan Fungsi PPID"
                class="img-fluid mx-auto d-block"
                style="max-width: 700px;"
            >

        </div>
    </div>

</div>
@endsection
