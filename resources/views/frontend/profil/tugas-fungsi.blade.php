@extends('layouts.app')

@section('title', 'Tugas dan Tanggung Jawab - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Tugas dan Tanggung Jawab</h2>
    
    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs mb-4" id="tugasFungsiTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button 
                class="nav-link active" 
                id="ppid-tab" 
                data-bs-toggle="tab" 
                data-bs-target="#ppid" 
                type="button" 
                role="tab" 
                aria-controls="ppid" 
                aria-selected="true"
                style="font-weight: 600; font-size: 16px;"
            >
                PPID
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button 
                class="nav-link" 
                id="ppid-pelaksana-tab" 
                data-bs-toggle="tab" 
                data-bs-target="#ppid-pelaksana" 
                type="button" 
                role="tab" 
                aria-controls="ppid-pelaksana" 
                aria-selected="false"
                style="font-weight: 600; font-size: 16px;"
            >
                PPID Pelaksana
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content" id="tugasFungsiTabContent">
        
        {{-- PPID Tab --}}
        <div 
            class="tab-pane fade show active" 
            id="ppid" 
            role="tabpanel" 
            aria-labelledby="ppid-tab"
        >
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <img 
                        src="{{ asset('images/tugas.jpg') }}" 
                        alt="Tugas dan Fungsi PPID"
                        class="img-fluid mx-auto d-block"
                        style="max-width: 700px;"
                    >
                </div>
            </div>
        </div>

        {{-- PPID Pelaksana Tab --}}
        <div 
            class="tab-pane fade" 
            id="ppid-pelaksana" 
            role="tabpanel" 
            aria-labelledby="ppid-pelaksana-tab"
        >
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <img 
                        src="{{ asset('images/tugas-ppid-pelaksana.jpg') }}" 
                        alt="Tugas dan Fungsi PPID Pelaksana"
                        class="img-fluid mx-auto d-block"
                        style="max-width: 700px;"
                    >
                </div>
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    /* Custom styling untuk tabs */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
    }
    
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: #0d6efd;
        background-color: #f8f9fa;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border-bottom: 3px solid #0d6efd;
    }
    
    .card {
        border-radius: 8px;
    }
    
    .tab-content {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@endsection