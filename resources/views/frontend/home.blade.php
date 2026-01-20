@extends('layouts.app')

@section('title', 'Beranda - PPID')

@push('styles')
    {{-- Load semua CSS home --}}
    <link rel="stylesheet" href="{{ asset('css/home/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/quick-links.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/agenda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/news.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/ppid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/stats.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/aplikasi-terkait.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/statistics.css') }}">
@endpush

@section('content')
    @include('components.hero-slider')
    
    <div class="container my-5">
        @include('components.welcome-banner')
        @include('components.quick-links')
        @include('components.agenda-section', ['agendaKegiatan' => $agendaKegiatan])
        @include('components.news-section', ['beritaTerbaru' => $beritaTerbaru])
    </div>
    
    @include('components.ppid-section')
    
    {{-- STATISTIK SECTION --}}
    @include('components.statistics-section')
    
    @include('components.gallery-section', ['galeriTerbaru' => $galeriTerbaru])
    
    {{-- APLIKASI TERKAIT --}}
    @include('components.aplikasi-terkait')
@endsection

@push('scripts')
    {{-- Load JavaScript home --}}
    <script src="{{ asset('js/home/carousel.js') }}"></script>
    <script src="{{ asset('js/home/gallery.js') }}"></script>
    
    {{-- Chart.js Library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    {{-- Statistics Chart --}}
    <script src="{{ asset('js/home/statistics.js') }}"></script>
@endpush