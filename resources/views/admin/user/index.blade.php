@extends('layouts.app')

@section('content')
<div class="row border rounded bg-white mb-2" style="padding: 2vh; margin-left: 0px; margin-right: 0px">
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $totalUser }}</h5>
                <p class="mb-0">Total Pengguna</p>
            </div>
            <div class="avatar me-sm-4">
                <span class="avatar-initial rounded bg-label-secondary text-heading">
                    <i class="bx bx-user bx-md"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none me-4">
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $totalAdmin }}</h5>
                <p class="mb-0">Jumlah Admin</p>
            </div>
            <div class="avatar me-lg-4">
                <span class="avatar-initial rounded bg-label-warning text-heading">
                    <i class="bx bx-user bx-md"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none">
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $totalDosen }}</h5>
                <p class="mb-0">Jumlah Dosen</p>
            </div>
            <div class="avatar me-sm-4">
                <span class="avatar-initial rounded bg-label-success text-heading">
                    <i class="bx bx-user bx-md"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $totalMahasiswa }}</h5>
                <p class="mb-0">Jumlah Mahasiswa</p>
            </div>
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-info text-heading">
                    <i class="bx bx-user bx-md"></i>
                </span>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pengguna</h5>
        <div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-export me-1"></i> Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('user/export/excel') }}" id="export-excel">Excel</a></li>
                    <li><a class="dropdown-item" href="{{ url('user/export/pdf') }}" id="export-pdf">PDF</a></li>
                </ul>
            </div>
            <button class="btn btn-primary ms-2" onclick="modalAction('{{ url('user/create-ajax') }}')">
                <i class="bx bx-plus"></i> Tambah Pengguna
            </button>
        </div>
    </div>

    <div class="row ms-3">
        <div class="col-md-3">
            <select id="filter-role" class="form-select">
                <option value="">Semua User</option>
                <option value="admin">Admin</option>
                <option value="dosen_pembimbing">Dosen Pembimbing</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
        </div>
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
                        <th>Status</th>
                        <th>Aksi Status</th>
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
                { data: 'status', name: 'status', className: 'text-center' },
                { data: 'aksi_status', name: 'aksi_status', orderable: false, searchable: false, className: 'text-center' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        // Trigger reload datatable saat filter berubah
        $('#filter-role').on('change', function () {
            dataUser.ajax.reload();
        });
    });

    $(document).on('submit', '.toggle-status-form', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        let form = $(this);
        let button = form.find('button[type="submit"]');
        let originalHtml = button.html();

        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

        let url = form.attr('action');

        $.post(url, form.serialize(), function(res) {
            if (res.status) {
                Swal.fire({
                    title: 'Berhasil',
                    text: res.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
                dataUser.ajax.reload();
            } else {
                Swal.fire({
                    title: 'Gagal',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }
        }).fail(function() {
            Swal.fire('Error', 'Terjadi kesalahan.', 'error');
        }).always(function() {
            button.prop('disabled', false).html(originalHtml);
        });

        return false;
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