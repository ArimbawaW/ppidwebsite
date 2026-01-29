{{-- resources/views/frontend/keberatan/hasil.blade.php --}}
@extends('layouts.app')

@section('title', 'Hasil Cek Keberatan')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Hasil Cek Keberatan</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nomor Registrasi Keberatan:</strong></p>
                    <p class="text-muted">{{ $keberatan->nomor_registrasi }}</p>
                </div>
                
                @if($keberatan->nomor_registrasi_permohonan)
                <div class="col-md-6">
                    <p><strong>Nomor Registrasi Permohonan:</strong></p>
                    <p class="text-muted">{{ $keberatan->nomor_registrasi_permohonan }}</p>
                </div>
                @endif
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nama Pemohon:</strong></p>
                    <p class="text-muted">{{ $keberatan->nama_pemohon }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email:</strong></p>
                    <p class="text-muted">{{ $keberatan->email }}</p>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Tanggal Pengajuan:</strong></p>
                    <p class="text-muted">{{ $keberatan->created_at->format('d M Y H:i') }} WIB</p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Alasan Keberatan:</strong></p>
                <div class="p-3 bg-light rounded">
                    <p class="mb-0">{{ $keberatan->alasan_keberatan_label }}</p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Status:</strong></p>
                <p>
                    @if($keberatan->status == 'pending')
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                    @elseif($keberatan->status == 'diproses')
                        <span class="badge bg-info fs-6 px-3 py-2">Diproses</span>
                    @elseif($keberatan->status == 'selesai')
                        <span class="badge bg-success fs-6 px-3 py-2">Selesai</span>
                    @else
                        <span class="badge bg-danger fs-6 px-3 py-2">Ditolak</span>
                    @endif
                </p>
            </div>

            @if($keberatan->keterangan)
            <div class="mb-3">
                <p><strong>Keterangan dari Admin:</strong></p>
                <div class="alert alert-info">
                    <p class="mb-0" style="white-space: pre-line;">{{ $keberatan->keterangan }}</p>
                </div>
            </div>
            @endif

            {{-- SECTION: Tanggapan Atasan PPID --}}
            @if($keberatan->tanggapan_atasan_ppid)
            <hr>
            <div class="mb-3">
                <h5 class="fw-bold text-primary mb-3">
                    <i class="bi bi-person-badge me-2"></i>Tanggapan Atasan PPID
                </h5>
                
                @if($keberatan->nama_atasan_ppid || $keberatan->jabatan_atasan_ppid)
                <div class="row mb-2">
                    @if($keberatan->nama_atasan_ppid)
                    <div class="col-md-6">
                        <p><strong>Nama Atasan PPID:</strong></p>
                        <p class="text-muted">{{ $keberatan->nama_atasan_ppid }}</p>
                    </div>
                    @endif
                    @if($keberatan->jabatan_atasan_ppid)
                    <div class="col-md-6">
                        <p><strong>Jabatan:</strong></p>
                        <p class="text-muted">{{ $keberatan->jabatan_atasan_ppid }}</p>
                    </div>
                    @endif
                </div>
                @endif
                
                @if($keberatan->nomor_surat_tanggapan || $keberatan->tanggal_surat_tanggapan)
                <div class="row mb-2">
                    @if($keberatan->nomor_surat_tanggapan)
                    <div class="col-md-6">
                        <p><strong>Nomor Surat Tanggapan:</strong></p>
                        <p class="text-muted">{{ $keberatan->nomor_surat_tanggapan }}</p>
                    </div>
                    @endif
                    @if($keberatan->tanggal_surat_tanggapan)
                    <div class="col-md-6">
                        <p><strong>Tanggal Surat:</strong></p>
                        <p class="text-muted">{{ $keberatan->tanggal_surat_tanggapan->format('d F Y') }}</p>
                    </div>
                    @endif
                </div>
                @endif
                
                <div class="alert alert-primary">
                    <p class="mb-0" style="white-space: pre-line;">{{ $keberatan->tanggapan_atasan_ppid }}</p>
                </div>
            </div>
            @endif

            {{-- SECTION: Form Tanggapan Pemohon --}}
            @if($keberatan->tanggapan_atasan_ppid && !$keberatan->tanggapan_pemohon)
            <hr>
            <div class="mb-3">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-left-quote me-2"></i>Berikan Tanggapan Anda
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Atasan PPID telah memberikan tanggapan atas keberatan Anda. 
                            Silakan berikan tanggapan atau komentar Anda terhadap keputusan tersebut.
                        </p>

                        <form action="{{ route('keberatan.submit-tanggapan', $keberatan->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">
                                    Email untuk Verifikasi <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $keberatan->email) }}"
                                       placeholder="Masukkan email Anda untuk verifikasi"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="bi bi-shield-lock me-1"></i>
                                    Email harus sesuai dengan email yang terdaftar pada keberatan ini
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="tanggapan_pemohon" class="form-label fw-bold">
                                    Tanggapan Anda <span class="text-danger">*</span>
                                </label>
                                <textarea name="tanggapan_pemohon" 
                                          id="tanggapan_pemohon"
                                          class="form-control @error('tanggapan_pemohon') is-invalid @enderror" 
                                          rows="6" 
                                          placeholder="Tuliskan tanggapan atau komentar Anda terhadap keputusan keberatan ini (minimal 10 karakter)..."
                                          required>{{ old('tanggapan_pemohon') }}</textarea>
                                @error('tanggapan_pemohon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong> Tanggapan yang Anda kirimkan akan diteruskan kepada admin dan atasan PPID. 
                                Pastikan tanggapan Anda sopan dan konstruktif.
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-send me-2"></i>Kirim Tanggapan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- SECTION: Tanggapan Pemohon (Sudah Diisi) --}}
            @if($keberatan->tanggapan_pemohon)
            <hr>
            <div class="mb-3">
                <h5 class="fw-bold text-success mb-3">
                    <i class="bi bi-chat-left-quote me-2"></i>Tanggapan Anda
                </h5>
                <div class="alert alert-success">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <strong>Tanggapan Anda:</strong>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i>Terkirim
                        </span>
                    </div>
                    <p class="mb-0" style="white-space: pre-line;">{{ $keberatan->tanggapan_pemohon }}</p>
                </div>
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Tanggapan Anda telah diterima dan diteruskan kepada admin.
                </small>
            </div>
            @endif

            {{-- SECTION: Keputusan Mediasi --}}
            @if($keberatan->keputusan_mediasi)
            <hr>
            <div class="mb-3">
                <h5 class="fw-bold text-warning mb-3">
                    <i class="bi bi-clipboard-check me-2"></i>Keputusan Hasil Mediasi/Ajudikasi
                </h5>
                <div class="alert alert-warning">
                    <p class="mb-0" style="white-space: pre-line;">{{ $keberatan->keputusan_mediasi }}</p>
                </div>
            </div>
            @endif

            {{-- SECTION: Putusan Pengadilan --}}
            @if($keberatan->putusan_pengadilan)
            <hr>
            <div class="mb-3">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="bi bi-bank me-2"></i>Putusan Pengadilan
                </h5>
                <div class="alert alert-danger">
                    <p class="mb-0" style="white-space: pre-line;">{{ $keberatan->putusan_pengadilan }}</p>
                </div>
            </div>
            @endif

            <hr>

            <div class="d-flex gap-2">
                <a href="{{ route('keberatan.cek') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cek Lagi
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .alert {
        border-radius: 8px;
    }
    
    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
@endpush