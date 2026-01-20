@extends('layouts.app')

@section('title', 'Cek Status Keberatan')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Cek Status Keberatan</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('keberatan.cek.proses') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nomor_registrasi" class="form-label">Nomor Registrasi Keberatan</label>
                    <input type="text" name="nomor_registrasi" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Cek Status</button>
            </form>
        </div>
    </div>
</div>
@endsection