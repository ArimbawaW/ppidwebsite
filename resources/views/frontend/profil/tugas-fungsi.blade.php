@extends('layouts.app')

@section('title', 'Struktur Organisasi - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Tugas dan Fungsi</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- GAMBAR TUGAS & FUNGSI --}}
            <img 
                src="{{ asset('images/tugas.jpg') }}" 
                alt="Tugas dan Fungsi PPID"
                class="img-fluid mx-auto d-block"
                style="max-width: 700px;"
            >

        </div>
    </div>

</div>
@endsection
