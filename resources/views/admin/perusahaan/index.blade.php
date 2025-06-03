@extends('layouts.app')

@section('content')
<div class="card-stats">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-dark">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Jumlah Perusahaan</h5>
                    <p class="card-text fs-4" >{{ $totalPerusahaan }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-dark">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Jumlah Bidang Industri</h5>
                    <p class="card-text fs-4">{{ $totalBidangIndustri }}</p>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <select id="filter-bidang-industri" class="form-select">
            <option value="">-- Semua Bidang Industri --</option>
            @foreach (\App\Models\PerusahaanMitra::select('bidang_industri')->distinct()->get() as $item)
                <option value="{{ $item->bidang_industri }}">{{ $item->bidang_industri }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Perusahaan</h5>
        <button class="btn btn-primary" onclick="modalAction('{{ url('perusahaan/create-ajax') }}')">
            <i class="bx bx-plus"></i> Tambah Perusahaan
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="table-perusahaan" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Perusahaan</th>
                        <th>Alamat</th>
                        <th>Jenis Perusahaan</th>
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

    var dataPerusahaan;
    $(document).ready(function () {
        dataPerusahaan = $('#table-perusahaan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('perusahaan/list') }}",
                data: function (d) {
                    d.bidang_industri = $('#filter-bidang-industri').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { 
                    data: 'nama_perusahaan', 
                    name: 'nama_perusahaan',
                    render: function(data, type, row) {
                        let content = '<div class="d-flex align-items-center">';
                        
                        content += '<div class="avatar avatar-sm me-2">';
                            if (row.path_logo) {
                                content += '<img src="' + row.path_logo + '" alt="Logo ' + data + '" class="avatar-img rounded" style="object-fit: contain; width: 100%; height: 100%;">';
                            } else {
                                content += '<span class="avatar-initial rounded bg-label-secondary">' +
                                        '<i class="bx bx-buildings"></i>' +
                                        '</span>';
                            }
                        content += '</div>';
                        
                        content += '<div>' +
                                  '<div class="fw-semibold">' + data + '</div>' +
                                  '<small class="text-muted">Kode: ' + (row.bidang_industri || '-') + '</small>' +
                                  '</div>' +
                                  '</div>';
                        
                        return content;
                    }
                },
                { data: 'alamat', name: 'alamat' },
                { data: 'jenis_perusahaan', name: 'jenis_perusahaan' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ]
        });
        $('#filter-bidang-industri').on('change', function () {
            dataPerusahaan.draw();
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
                    dataPerusahaan.ajax.reload();
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