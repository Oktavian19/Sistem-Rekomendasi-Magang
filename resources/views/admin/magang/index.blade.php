@extends('layouts.app')

@section('content')
<div class="row border rounded bg-white mb-2" style="padding: 2vh; margin-left: 0px; margin-right: 0px">
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $statistik['total'] }}</h5>
                <p class="mb-0">Total Magang</p>
            </div>
            <div class="avatar me-sm-4">
                <span class="avatar-initial rounded bg-label-secondary text-heading">
                    <i class="bx bx-group bx-md"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none me-4">
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $statistik['aktif'] }}</h5>
                <p class="mb-0">Magang Aktif</p>
            </div>
            <div class="avatar me-lg-4">
                <span class="avatar-initial rounded bg-label-success text-heading">
                    <i class="bx bx-check-circle bx-md"></i>
                </span>
            </div>
        </div>
        <hr class="d-none d-sm-block d-lg-none">
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $statistik['selesai'] }}</h5>
                <p class="mb-0">Magang Selesai</p>
            </div>
            <div class="avatar me-sm-4">
                <span class="avatar-initial rounded bg-label-warning text-heading">
                    <i class="bx bx-time-five bx-md"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $statistik['batal'] }}</h5>
                <p class="mb-0">Magang Batal</p>
            </div>
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-danger text-heading">
                    <i class="bx bx-x-circle bx-md"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Magang Mahasiswa</h5>
    </div>

    <div class="row ms-3">
        <div class="col-md-3 mb-3">
            <form action="{{ route('admin.kelola-magang.index') }}" method="GET">
                <div class="input-group">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="col-md-4 mb-3">
            <form action="{{ route('admin.kelola-magang.index') }}" method="GET">
                <div class="input-group">
                    <select name="prodi" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Program Studi</option>
                        @foreach($prodiList as $prodi)
                            <option value="{{ $prodi->id_program_studi }}" 
                                {{ request('prodi') == $prodi->id_program_studi ? 'selected' : '' }}>
                                {{ $prodi->nama_program_studi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
            </form>
        </div>
    </div>

    <div class="row ms-3 mb-3">
        <div class="col-md-6">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-export me-1"></i> Export
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ url('kelola-magang/export/excel') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}">
                            Excel
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('kelola-magang/export/pdf') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}">
                            PDF
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="magangTable" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Lowongan</th>
                        <th>Status</th>
                        <th>Dosen Pembimbing</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($magang as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <h6 class="mb-0">
                                            <a href="javascript:void(0)"
                                                onclick="showDetailModal({{ $item['id_magang'] }}, 'mahasiswa')">
                                                {{ $item['mahasiswa']['nama'] }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">{{ $item['mahasiswa']['nim'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="javascript:void(0)"
                                    onclick="showDetailModal({{ $item['id_magang'] }}, 'lowongan')">
                                    <strong>{{ $item['lowongan']['nama_posisi'] }}</strong><br>
                                </a>
                                <small class="text-muted">{{ $item['lowongan']['nama_perusahaan'] }}</small>
                            </td>
                            <td>
                                <a href="javascript:void(0)"
                                    onclick="showDetailModal({{ $item['id_magang'] }}, 'magang')">
                                    <span class="badge 
                                    @if ($item['status_magang'] == 'aktif') bg-label-success 
                                    @elseif($item['status_magang'] == 'batal') bg-label-danger 
                                    @else bg-label-warning @endif">
                                        {{ ucfirst($item['status_magang']) }}
                                    </span>
                                </a>
                            </td>
                            <td>
                                @if ($item['dosen_pembimbing'])
                                    {{ $item['dosen_pembimbing']['nama'] }}
                                @else
                                    <span class="text-muted">(Belum ada dosen)</span>
                                @endif
                            </td>
                            <td>
                                @if ($item['status_magang'] == 'aktif')
                                    @if ($item['dosen_pembimbing'])
                                        <button class="btn btn-sm btn-warning" 
                                            onclick="showUbahStatusModal({{ $item['id_magang'] }})">
                                            <i class="bx bx-edit me-1"></i> Ubah Status
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-primary" 
                                            onclick="showPlotDosenModal({{ $item['id_magang'] }}, {{ $item['id_dosen_pembimbing'] ?? 'null' }})">
                                            <i class="bx bx-user-plus me-1"></i> Plot Dosen
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-sm btn-success" 
                                        onclick="showDetailModal({{ $item['id_magang'] }}, 'feedback')">
                                        <i class="bx bx-message-detail me-1"></i> Feedback
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                <!-- Konten akan dimuat via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Plot Dosen -->
<div class="modal fade" id="plotDosenModal" tabindex="-1" aria-labelledby="plotDosenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="plotDosenModalLabel">Plot Dosen Pembimbing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="plotDosenForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="status_magang" value="aktif">
                    <div class="mb-3">
                        <label for="id_dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                        <select name="id_dosen_pembimbing" id="id_dosen_pembimbing" class="form-select select2-dosen" required>
                            <option value="">-- Pilih Dosen --</option>
                            @foreach ($dosenList as $dosen)
                                <option value="{{ $dosen->id_dosen_pembimbing }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Status Magang -->
<div class="modal fade" id="ubahStatusModal" tabindex="-1" aria-labelledby="ubahStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahStatusModalLabel">Ubah Status Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ubahStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_magang" class="form-label">Status Magang</label>
                        <select name="status_magang" id="status_magang" class="form-select" required>
                            <option value="selesai">Selesai</option>
                            <option value="batal">Batal</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#magangTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    zeroRecords: "Tidak ada data ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                }
            });
        });

        $('.select2-dosen').select2({
            placeholder: 'Cari atau pilih dosen',
            allowClear: true,
            dropdownParent: $('#plotDosenModal'),
            width: '100%',
            language: {
                noResults: function() {
                    return "Dosen tidak ditemukan";
                }
            }
        });

        $('#plotDosenModal').on('hidden.bs.modal', function () {
            $('.select2-dosen').val(null).trigger('change');
        });

        function showPlotDosenModal(magangId, dosenId = null) {
            const modal = $('#plotDosenModal');
            const form = $('#plotDosenForm');
            
            form.attr('action', `/kelola-magang/${magangId}/status`);
            
            const selectElement = $('#id_dosen_pembimbing');
            if (dosenId) {
                selectElement.val(dosenId).trigger('change');
            } else {
                selectElement.val(null).trigger('change');
            }
            
            modal.modal('show');
            
            modal.on('shown.bs.modal', function() {
                $('.select2-search__field').focus();
            });
        }

        function showDetailModal(id, detail) {
            $('#modalBodyContent').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Memuat data...</p>
                </div>
            `);

            $('#detailModal').modal('show');

            $.get(`/kelola-magang/${id}/${detail}`, function(data) {
                $('#modalBodyContent').html(data);
            }).fail(function() {
                $('#modalBodyContent').html(`
                    <div class="alert alert-danger">
                        Gagal memuat data magang. Silakan coba lagi.
                    </div>
                `);
            });
        }

        $('#plotDosenForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#plotDosenModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Dosen pembimbing berhasil diperbarui',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memperbarui dosen pembimbing'
                    });
                }
            });
        });

        function showUbahStatusModal(magangId) {
            const modal = $('#ubahStatusModal');
            const form = $('#ubahStatusForm');
            
            form.attr('action', `/kelola-magang/${magangId}/status`);
            modal.modal('show');
        }

        $('#ubahStatusForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#ubahStatusModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Status magang berhasil diperbarui',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memperbarui status magang'
                    });
                }
            });
        });
    </script>
@endpush