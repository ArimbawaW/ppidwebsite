@extends('layouts.admin')

@section('title', 'Detail Kontak - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Kontak</h1>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Informasi Kontak</h5>
        <p><strong>Nama:</strong> {{ $kontak->nama }}</p>
        <p><strong>Email:</strong> {{ $kontak->email }}</p>
        <p><strong>Subjek:</strong> {{ $kontak->subjek }}</p>
        <p><strong>Status:</strong> <span class="badge bg-warning">{{ ucfirst($kontak->status) }}</span></p>
        <p><strong>Tanggal:</strong> {{ $kontak->created_at->format('d M Y H:i') }}</p>
        <hr>
        <p><strong>Pesan:</strong></p>
        <p>{{ $kontak->pesan }}</p>

        <form action="{{ route('admin.kontak.update', $kontak->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="unread" {{ $kontak->status == 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ $kontak->status == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ $kontak->status == 'replied' ? 'selected' : '' }}>Replied</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
            <a href="{{ route('admin.kontak.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection

