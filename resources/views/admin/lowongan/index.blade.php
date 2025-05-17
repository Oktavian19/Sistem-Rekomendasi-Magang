@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Lowongan</h5>
        <button class="btn btn-primary" onclick="modalAction('{{ url('lowongan/create-ajax') }}')">
            <i class="bx bx-plus"></i> Tambah Lowongan
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="table-lowongan" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Posisi</th>
                        <th>Perusahaan</th>
                        <th>Kategori Keahlian</th>
                        <th>Kuota</th>
                        <th>Tanggal Buka</th>
                        <th>Tanggal Tutup</th>
                        <th>Durasi Magang</th>
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
    

    $(document).ready(function () {
        $('#table-lowongan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('lowongan/list') }}",
            columnDefs: [
                { targets: [8], orderable: false, width: '200px' }
            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'nama_posisi', name: 'nama_posisi' },
                { data: 'nama_perusahaan', name: 'nama_perusahaan' },
                { data: 'kategori_keahlian', name: 'kategori_keahlian' },
                { data: 'kuota', name: 'kuota', className: 'text-center' },
                { data: 'tanggal_buka', name: 'tanggal_buka' },
                { data: 'tanggal_tutup', name: 'tanggal_tutup' },
                { data: 'durasi_magang', name: 'durasi_magang' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ]
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
                    setTimeout(function() {
                        window.location.reload();
                    }, 2100);
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