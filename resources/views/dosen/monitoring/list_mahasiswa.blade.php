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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Placeholder modal kosong -->
    <div class="modal fade" id="modalDetailMagang" tabindex="-1" aria-hidden="true">
        <div id="modal-content-wrapper"></div>
    </div>
@endsection

@push('styles')
    <style>
        .rating-input i {
            cursor: pointer;
            color: #ddd;
            transition: color 0.2s;
            font-size: 1.5rem;
        }

        .rating-input i.active {
            color: #ffc107;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            const table = $('#table-mahasiswa').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('monitoring/list') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'nim'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'no_hp'
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

            $('#table-mahasiswa').on('click', '.btn-detail', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/monitoring/' + id,
                    type: 'GET',
                    success: function(response) {
                        $('#modal-content-wrapper').html(response);
                        const modal = new bootstrap.Modal(document.getElementById(
                            'modalDetailMagang'));
                        modal.show();
                    },
                    error: function() {
                        alert('Gagal mengambil detail magang.');
                    }
                });
            });


        });
    </script>
@endpush
