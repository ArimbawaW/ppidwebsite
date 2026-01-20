@extends('layouts.app')

@section('title', $informasi->judul . ' - PPID')

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $informasi->judul }}</h2>
            <p class="text-muted">
                <span class="badge bg-primary">{{ $informasi->kategori_label }}</span>
                <span class="ms-2">{{ $informasi->created_at->format('d M Y') }}</span>
            </p>
            <hr>
            <div class="card-text">
                {!! nl2br(e($informasi->deskripsi)) !!}
            </div>
            <hr>
            <div class="mt-3">
                @if($informasi->file_path)
                    <a href="{{ route('informasi-publik.download', $informasi->id) }}" class="btn btn-primary">Download File</a>
                @endif
                @if($informasi->link_download)
                    <a href="{{ $informasi->link_download }}" class="btn btn-success" target="_blank">Download Link</a>
                @endif
                <a href="{{ route('informasi-publik.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection

