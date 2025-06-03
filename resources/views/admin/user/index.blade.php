@extends('layouts.app')

@section('content')
<div class="card-stats">
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <div class="fs-4 fw-bold">{{ $totalUser }}</div>
                <div class="text-muted">Total Pengguna</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <div class="fs-4 fw-bold">{{ $totalAdmin }}</div>
                <div class="text-muted">Jumlah Admin</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <div class="fs-4 fw-bold">{{ $totalDosen }}</div>
                <div class="text-muted">Jumlah Dosen</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <div class="fs-4 fw-bold">{{ $totalMahasiswa }}</div>
                <div class="text-muted">Jumlah Mahasiswa</div>
            </div>
        </div>
    </div>    
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <select id="filter-role" class="form-select">
            <option value="">Semua User</option>
            <option value="admin">Admin</option>
            <option value="dosen_pembimbing">Dosen Pembimbing</option>
            <option value="mahasiswa">Mahasiswa</option>
        </select>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pengguna</h5>
        <button class="btn btn-primary" onclick="modalAction('{{ url('user/create-ajax') }}')">
            <i class="bx bx-plus"></i> Tambah Pengguna
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="table-user" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
     data-backdrop="static" data-keyboard="false" aria-hidden="true">
</div>
@endsection

@push('scripts')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var dataUser;
    $(document).ready(function () {
        dataUser = $('#table-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('user/list') }}",
                data: function (d) {
                    d.role = $('#filter-role').val(); // ambil filter dari dropdown
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'username', name: 'username' },
                { data: 'nama', name: 'nama' },
                { data: 'role', name: 'role' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        // Trigger reload datatable saat filter berubah
        $('#filter-role').on('change', function () {
            dataUser.ajax.reload();
        });
    });

    $(document).on('submit', 'form', function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method');
        let data = new FormData(this);

        if ($.fn.validate && form.hasClass('validate')) {
            if (!form.valid()) return false;
        }

        $.ajax({
            url: url,
            type: method,
            data: data,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    dataUser.ajax.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    });
                    if (res.msgField) {
                        $('.error-text').text('');
                        $.each(res.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                    }
                }
            },
            error: function(xhr) {
                $('#myModal').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            }
        });
    });
</script>
@endpush