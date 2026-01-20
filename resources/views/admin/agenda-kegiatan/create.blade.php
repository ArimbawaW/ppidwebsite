@extends('layouts.admin')

@section('title', 'Tambah Agenda Kegiatan')

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Agenda Kegiatan</h2>
            <p class="text-muted mb-0">Buat agenda kegiatan baru yang akan ditampilkan di homepage</p>
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

    {{-- Form Create --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.agenda-kegiatan.store') }}" method="POST">
                @csrf

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
                                   value="{{ old('judul') }}" 
                                   placeholder="Contoh: Strategi Komunikasi Berbasis Isu Publik"
                                   required
                                   autofocus>
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
                                   value="{{ old('tanggal', now()->format('Y-m-d')) }}" 
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
                                   value="{{ old('waktu_mulai', '09:00') }}">
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: 09:00 (opsional)</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Waktu Selesai</label>
                            <input type="time" 
                                   name="waktu_selesai" 
                                   class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   value="{{ old('waktu_selesai') }}">
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Harus lebih besar dari waktu mulai (opsional)</small>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" 
                              class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="4"
                              placeholder="Deskripsi singkat tentang kegiatan ini...">{{ old('deskripsi') }}</textarea>
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
                                   value="{{ old('lokasi') }}"
                                   placeholder="Contoh: Ruang Rapat Lantai 3, Gedung Utama">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tempat pelaksanaan kegiatan (opsional)</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Penyelenggara</label>
                            <input type="text" 
                                   name="penyelenggara" 
                                   class="form-control @error('penyelenggara') is-invalid @enderror" 
                                   value="{{ old('penyelenggara') }}"
                                   placeholder="Contoh: Kementerian Sekre">
                            @error('penyelenggara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pihak yang menyelenggarakan (opsional)</small>
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
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }} selected>
                            Akan Datang
                        </option>
                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>
                            Sedang Berlangsung
                        </option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
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
                               {{ old('is_active', true) ? 'checked' : '' }}>
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
                    <strong>Tips Mengisi Form:</strong> 
                    <ul class="mb-0 mt-2">
                        <li>Field yang wajib diisi ditandai dengan <span class="text-danger">*</span></li>
                        <li>Waktu, lokasi, penyelenggara, dan deskripsi bersifat opsional</li>
                        <li>Gunakan status "Akan Datang" untuk kegiatan yang belum terlaksana</li>
                        <li>Pastikan tanggal sudah benar sebelum menyimpan</li>
                        <li>Agenda yang aktif akan otomatis muncul di homepage</li>
                    </ul>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Simpan Agenda
                    </button>
                    <button type="reset" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                    </button>
                    <a href="{{ route('admin.agenda-kegiatan.index') }}" class="btn btn-secondary btn-lg">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Contoh Tampilan --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-image me-2"></i>Contoh Tampilan di Homepage
            </h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">Berikut adalah contoh bagaimana agenda akan ditampilkan:</p>
            
            <div class="row">
                {{-- Contoh 1 --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="text-center me-3" 
                                     style="min-width: 60px; padding: 10px; background: #0e5b73; border-radius: 8px;">
                                    <div class="text-white fw-bold" style="font-size: 24px; line-height: 1;">
                                        3
                                    </div>
                                    <div class="text-white" style="font-size: 12px;">
                                        Jul
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold" style="color: #0e5b73; line-height: 1.3;">
                                        Strategi Komunikasi Berbasis Isu Publik
                                    </h6>
                                </div>
                            </div>
                            <div class="small text-muted">
                                <div class="mb-1">
                                    <i class="bi bi-clock me-1"></i>
                                    09:00 - 12:00 WIB
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    Ruang Rapat Lantai 3
                                </div>
                                <div>
                                    <i class="bi bi-person me-1"></i>
                                    Kementerian Sekre
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-primary">Akan Datang</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contoh 2 --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="text-center me-3" 
                                     style="min-width: 60px; padding: 10px; background: #0e5b73; border-radius: 8px;">
                                    <div class="text-white fw-bold" style="font-size: 24px; line-height: 1;">
                                        5
                                    </div>
                                    <div class="text-white" style="font-size: 12px;">
                                        Jul
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold" style="color: #0e5b73; line-height: 1.3;">
                                        Rapat Koordinasi Tim PPID
                                    </h6>
                                </div>
                            </div>
                            <div class="small text-muted">
                                <div class="mb-1">
                                    <i class="bi bi-clock me-1"></i>
                                    14:00 WIB
                                </div>
                                <div>
                                    <i class="bi bi-geo-alt me-1"></i>
                                    Meeting Room Online
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-success">Sedang Berlangsung</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contoh 3 --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="text-center me-3" 
                                     style="min-width: 60px; padding: 10px; background: #0e5b73; border-radius: 8px;">
                                    <div class="text-white fw-bold" style="font-size: 24px; line-height: 1;">
                                        8
                                    </div>
                                    <div class="text-white" style="font-size: 12px;">
                                        Jul
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold" style="color: #0e5b73; line-height: 1.3;">
                                        Workshop Pelayanan Publik
                                    </h6>
                                </div>
                            </div>
                            <div class="small text-muted">
                                <div class="mb-1">
                                    <i class="bi bi-clock me-1"></i>
                                    08:00 - 16:00 WIB
                                </div>
                                <div>
                                    <i class="bi bi-person me-1"></i>
                                    Humas PKP
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-primary">Akan Datang</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
// Auto-set waktu selesai jika waktu mulai diisi
document.querySelector('input[name="waktu_mulai"]').addEventListener('change', function(e) {
    const waktuMulai = e.target.value;
    const waktuSelesaiInput = document.querySelector('input[name="waktu_selesai"]');
    
    if (waktuMulai && !waktuSelesaiInput.value) {
        // Tambah 2 jam otomatis
        const [hours, minutes] = waktuMulai.split(':');
        const newHours = (parseInt(hours) + 2).toString().padStart(2, '0');
        waktuSelesaiInput.value = `${newHours}:${minutes}`;
    }
});
</script>
@endpush