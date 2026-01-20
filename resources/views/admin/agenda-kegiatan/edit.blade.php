@extends('layouts.admin')

@section('title', 'Edit Agenda Kegiatan')

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Agenda Kegiatan</h2>
            <p class="text-muted mb-0">Ubah informasi agenda kegiatan</p>
        </div>
        <a href="{{ route('admin.agenda-kegiatan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    {{-- Alert Error --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Edit --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.agenda-kegiatan.update', $agendaKegiatan->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Judul & Tanggal --}}
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Judul Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul', $agendaKegiatan->judul) }}" 
                                   placeholder="Contoh: Strategi Komunikasi Berbasis Isu Publik"
                                   required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Judul kegiatan yang akan ditampilkan</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="tanggal" 
                                   class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal', $agendaKegiatan->tanggal->format('Y-m-d')) }}" 
                                   required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Waktu Mulai & Selesai --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Waktu Mulai</label>
                            <input type="time" 
                                   name="waktu_mulai" 
                                   class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   value="{{ old('waktu_mulai', $agendaKegiatan->waktu_mulai) }}">
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: 09:00</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Waktu Selesai</label>
                            <input type="time" 
                                   name="waktu_selesai" 
                                   class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   value="{{ old('waktu_selesai', $agendaKegiatan->waktu_selesai) }}">
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Harus lebih besar dari waktu mulai</small>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" 
                              class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="4"
                              placeholder="Deskripsi singkat tentang kegiatan ini...">{{ old('deskripsi', $agendaKegiatan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Opsional - Penjelasan detail tentang kegiatan</small>
                </div>

                {{-- Lokasi & Penyelenggara --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" 
                                   name="lokasi" 
                                   class="form-control @error('lokasi') is-invalid @enderror" 
                                   value="{{ old('lokasi', $agendaKegiatan->lokasi) }}"
                                   placeholder="Contoh: Ruang Rapat Lantai 3">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Penyelenggara</label>
                            <input type="text" 
                                   name="penyelenggara" 
                                   class="form-control @error('penyelenggara') is-invalid @enderror" 
                                   value="{{ old('penyelenggara', $agendaKegiatan->penyelenggara) }}"
                                   placeholder="Contoh: Kementerian Sekre">
                            @error('penyelenggara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Status <span class="text-danger">*</span>
                    </label>
                    <select name="status" 
                            class="form-select @error('status') is-invalid @enderror" 
                            required>
                        <option value="">-- Pilih Status --</option>
                        <option value="upcoming" {{ old('status', $agendaKegiatan->status) == 'upcoming' ? 'selected' : '' }}>
                            Akan Datang
                        </option>
                        <option value="ongoing" {{ old('status', $agendaKegiatan->status) == 'ongoing' ? 'selected' : '' }}>
                            Sedang Berlangsung
                        </option>
                        <option value="completed" {{ old('status', $agendaKegiatan->status) == 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Status akan menentukan badge yang ditampilkan di frontend
                    </small>
                </div>

                {{-- Aktif/Non-Aktif --}}
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" 
                               name="is_active" 
                               class="form-check-input" 
                               id="is_active" 
                               value="1" 
                               {{ old('is_active', $agendaKegiatan->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">
                            Aktifkan Agenda
                        </label>
                        <div class="text-muted small mt-1">
                            Jika tidak dicentang, agenda tidak akan ditampilkan di homepage
                        </div>
                    </div>
                </div>

                {{-- Info Card --}}
                <div class="alert alert-info mb-4">
                    <i class="bi bi-lightbulb me-2"></i>
                    <strong>Tips:</strong> 
                    <ul class="mb-0 mt-2">
                        <li>Pastikan tanggal dan waktu sudah benar</li>
                        <li>Gunakan status "Akan Datang" untuk kegiatan yang belum terlaksana</li>
                        <li>Ubah status menjadi "Selesai" setelah kegiatan berlangsung</li>
                        <li>Non-aktifkan agenda jika tidak ingin ditampilkan di homepage</li>
                    </ul>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Update Agenda
                    </button>
                    <a href="{{ route('admin.agenda-kegiatan.index') }}" class="btn btn-secondary btn-lg">
                        Batal
                    </a>
                    <button type="button" 
                            class="btn btn-outline-danger btn-lg ms-auto" 
                            onclick="confirmDelete()">
                        <i class="bi bi-trash me-2"></i>Hapus Agenda
                    </button>
                </div>

            </form>

            {{-- Form Delete (Hidden) --}}
            <form id="deleteForm" 
                  action="{{ route('admin.agenda-kegiatan.destroy', $agendaKegiatan->id) }}" 
                  method="POST" 
                  class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    {{-- Preview Card --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-eye me-2"></i>Preview Tampilan di Homepage
            </h5>
        </div>
        <div class="card-body">
            <div class="card h-100 shadow-sm border-0" style="max-width: 350px;">
                <div class="card-body">
                    {{-- Tanggal --}}
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-center me-3" 
                             style="min-width: 60px; padding: 10px; background: #0e5b73; border-radius: 8px;">
                            <div class="text-white fw-bold" style="font-size: 24px; line-height: 1;">
                                {{ $agendaKegiatan->tanggal->format('d') }}
                            </div>
                            <div class="text-white" style="font-size: 12px;">
                                {{ $agendaKegiatan->tanggal->locale('id')->isoFormat('MMM') }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold" style="color: #0e5b73; line-height: 1.3;">
                                {{ $agendaKegiatan->judul }}
                            </h6>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="small text-muted">
                        @if($agendaKegiatan->waktu_mulai)
                        <div class="mb-1">
                            <i class="bi bi-clock me-1"></i>
                            {{ date('H:i', strtotime($agendaKegiatan->waktu_mulai)) }}
                            @if($agendaKegiatan->waktu_selesai)
                                - {{ date('H:i', strtotime($agendaKegiatan->waktu_selesai)) }} WIB
                            @else
                                WIB
                            @endif
                        </div>
                        @endif

                        @if($agendaKegiatan->lokasi)
                        <div class="mb-1">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $agendaKegiatan->lokasi }}
                        </div>
                        @endif

                        @if($agendaKegiatan->penyelenggara)
                        <div>
                            <i class="bi bi-person me-1"></i>
                            {{ $agendaKegiatan->penyelenggara }}
                        </div>
                        @endif
                    </div>

                    {{-- Status Badge --}}
                    <div class="mt-3">
                        @if($agendaKegiatan->status == 'upcoming')
                            <span class="badge bg-primary">Akan Datang</span>
                        @elseif($agendaKegiatan->status == 'ongoing')
                            <span class="badge bg-success">Sedang Berlangsung</span>
                        @else
                            <span class="badge bg-secondary">Selesai</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus agenda ini?\n\nData yang dihapus tidak dapat dikembalikan.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush