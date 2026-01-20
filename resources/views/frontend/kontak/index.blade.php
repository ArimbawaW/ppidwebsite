@extends('layouts.app')

@section('title', 'Kontak - PPID')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Kontak Kami</h2>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Formulir Kontak</h5>
                    <form action="{{ route('kontak.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subjek" class="form-label">Subjek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subjek') is-invalid @enderror" id="subjek" name="subjek" value="{{ old('subjek') }}" required>
                            @error('subjek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('pesan') is-invalid @enderror" id="pesan" name="pesan" rows="5" required>{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Kontak</h5>
                    <p><strong>Alamat:</strong><br>
                    Jl. Contoh No. 123<br>
                    Jakarta 12345</p>
                    <p><strong>Email:</strong> info@ppid.local</p>
                    <p><strong>Telepon:</strong> (021) 1234-5678</p>
                    <p><strong>Jam Operasional:</strong><br>
                    Senin - Jumat: 08:00 - 16:00 WIB</p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Peta Lokasi</h5>
                    <div id="map" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function initMap() {
        // Ganti dengan koordinat lokasi PPID yang sebenarnya
        const location = { lat: -6.2088, lng: 106.8456 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: location,
        });
        new google.maps.Marker({
            position: location,
            map: map,
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
@endpush
@endsection

