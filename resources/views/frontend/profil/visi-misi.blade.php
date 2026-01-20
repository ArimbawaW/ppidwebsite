@extends('layouts.app')

@section('title', 'Struktur Organisasi - PPID')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- GAMBAR visi --}}
            <img 
                src="{{ asset('images/visi.png') }}" 
                alt="Tugas dan Fungsi PPID"
                class="img-fluid mx-auto d-block"
                style="max-width: 700px;"
            >

        </div>
    </div>

</div>
@endsection
