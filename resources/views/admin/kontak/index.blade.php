@extends('layouts.admin')

@section('title', 'Kontak - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Kontak</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="kontakTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Subjek</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#kontakTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.kontak.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'subjek', name: 'subjek' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush

