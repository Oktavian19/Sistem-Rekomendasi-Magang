@extends('layouts.app')

@section('content')
<div class="row border rounded bg-white mb-2" style="padding: 2vh; margin-left: 0px; margin-right: 0px">
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $totalLowongan }}</h5>
                <p class="mb-0">Jumlah Lowongan</p>
            </div>
            <div class="avatar me-sm-4">
                <span class="avatar-initial rounded bg-label-primary text-heading">
                    <i class="bx bx-briefcase-alt bx-md"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none me-4">
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $totalLowonganWFO }}</h5>
                <p class="mb-0">Lowongan WFO</p>
            </div>
            <div class="avatar me-lg-4">
                <span class="avatar-initial rounded bg-label-info text-heading">
                    <i class="bx bx-building-house bx-md"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none">
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $totalLowonganWFH }}</h5>
                <p class="mb-0">Lowongan WFH</p>
            </div>
            <div class="avatar me-sm-4">
                <span class="avatar-initial rounded bg-label-success text-heading">
                    <i class="bx bx-home-alt bx-md"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $totalLowonganHybrid }}</h5>
                <p class="mb-0">Lowongan Hybrid</p>
            </div>
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-warning text-heading">
                    <i class="bx bx-transfer-alt bx-md"></i>
                </span>
            </div>
        </div>
    </div>
</div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Lowongan</h5>
            <div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-export me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('lowongan/export/excel') }}" id="export-excel">Excel</a></li>
                        <li><a class="dropdown-item" href="{{ url('lowongan/export/pdf') }}" id="export-pdf">PDF</a></li>
                    </ul>
                </div>
                <button class="btn btn-primary ms-2" onclick="modalAction('{{ url('lowongan/create-ajax') }}')">
                    <i class="bx bx-plus"></i> Tambah Lowongan
                </button>
            </div>
        </div>

        <div class="row ms-3">
            <div class="col-md-4">
                <select id="filter-nama-posisi" class="form-select">
                    <option value="">Semua Posisi </option>
                    @foreach (\App\Models\Lowongan::select('nama_posisi')->distinct()->get() as $item)
                        <option value="{{ $item->nama_posisi }}">{{ $item->nama_posisi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select id="filter-jenis-pelaksanaan" class="form-select">
                    <option value="">Semua Jenis Pelaksanaan </option>
                    @foreach (\App\Models\OpsiPreferensi::where('id_kategori', '3')->get() as $item)
                        <option value="{{ $item->label }}">{{ $item->label }}</option>
                    @endforeach
                </select>
            </div>
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

        $('#export-excel, #export-pdf').on('click', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let nama_posisi = $('#filter-nama-posisi').val();
            let jenis_pelaksanaan = $('#filter-jenis-pelaksanaan').val();
            
            let params = [];
            if (nama_posisi) {
                params.push('nama_posisi=' + nama_posisi);
            }
            if (jenis_pelaksanaan) {
                params.push('jenis_pelaksanaan=' + jenis_pelaksanaan);
            }
            
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            
            window.location.href = url;
        });
    </script>
@endpush
