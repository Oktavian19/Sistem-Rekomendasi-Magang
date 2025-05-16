@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Mahasiswa</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="table-mahasiswa" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>No. HP</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#table-mahasiswa').DataTable({
            processing: true,
            serverSide: false,
            data: [
                {
                    "DT_RowIndex": 1,
                    "nim": "210101001",
                    "nama": "Andi Wijaya",
                    "email": "andi@example.com",
                    "no_hp": "081234567890"
                },
                {
                    "DT_RowIndex": 2,
                    "nim": "210101002",
                    "nama": "Budi Santoso",
                    "email": "budi@example.com",
                    "no_hp": "082345678901",
                },
                {
                    "DT_RowIndex": 3,
                    "nim": "210101003",
                    "nama": "Citra Lestari",
                    "email": "citra@example.com",
                    "no_hp": "083456789012",
                },
                {
                    "DT_RowIndex": 4,
                    "nim": "210101004",
                    "nama": "Dewi Anggraeni",
                    "email": "dewi@example.com",
                    "no_hp": "084567890123",
                },
                {
                    "DT_RowIndex": 5,
                    "nim": "210101005",
                    "nama": "Eko Prasetyo",
                    "email": "eko@example.com",
                    "no_hp": "085678901234",
                }
            ],
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    className: 'text-center', 
                    orderable: true, 
                    searchable: true 
                },
                { 
                    data: 'nama', 
                    name: 'nama',
                    render: function(data, type, row) {
                        return `<a href="{{ url('dosen/log-mahasiswa') }}" class="text-primary")">${data}</a>`;
                    }
                },
                { 
                    data: 'nim', 
                    name: 'nim' 
                },
                { 
                    data: 'email', 
                    name: 'email' 
                },
                { 
                    data: 'no_hp', 
                    name: 'no_hp' 
                }
            ]
        });
    });
</script>
@endpush