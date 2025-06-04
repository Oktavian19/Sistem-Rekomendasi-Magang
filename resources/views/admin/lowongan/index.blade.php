@extends('layouts.app')

@section('content')
    <div class="card-stats">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-white text-dark">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Jumlah Lowongan</h5>
                        <p class="card-text fs-4">{{ $totalLowongan }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-white text-dark">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Total Kuota</h5>
                        <p class="card-text fs-4">{{ $totalKuota }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="filter-nama-posisi" class="form-select">
                <option value="">-- Semua Posisi --</option>
                @foreach (\App\Models\Lowongan::select('nama_posisi')->distinct()->get() as $item)
                    <option value="{{ $item->nama_posisi }}">{{ $item->nama_posisi }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select id="filter-jenis-pelaksanaan" class="form-select">
                <option value="">-- Semua Jenis Pelaksanaan --</option>
                @foreach (\App\Models\OpsiPreferensi::where('id_kategori', '3')->get() as $item)
                    <option value="{{ $item->label }}">{{ $item->label }}</option>
                @endforeach
            </select>
        </div>
    </div>
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
                            <th>Perusahaan</th>
                            <th>Nama Posisi</th>
                            <th>Jenis Pelaksanaan</th>
                            <th>Durasi Magang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataLowongan;
        $(document).ready(function() {
            dataLowongan = $('#table-lowongan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('lowongan/list') }}",
                    data: function(d) {
                        d.nama_posisi = $('#filter-nama-posisi').val();
                        d.jenis_pelaksanaan = $('#filter-jenis-pelaksanaan').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_perusahaan',
                        name: 'nama_perusahaan'
                    },
                    {
                        data: 'nama_posisi',
                        name: 'nama_posisi'
                    },
                    {
                        data: 'jenis_pelaksanaan',
                        name: 'jenis_pelaksanaan'
                    },
                    {
                        data: 'durasi_magang',
                        name: 'durasi_magang'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
            $('#filter-nama-posisi').on('change', function() {
                dataLowongan.draw();
            });

            $('#filter-jenis-pelaksanaan').on('change', function() {
                dataLowongan.draw();
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
                        dataLowongan.ajax.reload();
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
