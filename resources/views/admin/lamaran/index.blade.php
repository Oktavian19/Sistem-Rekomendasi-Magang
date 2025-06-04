@extends('layouts.app')

@section('content')
<div class="row border rounded bg-white mb-2" style="padding: 2vh; margin-left: 0px; margin-right: 0px">
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
            <div>
                <h5 class="mb-0">{{ $statistik['total'] }}</h5>
                <p class="mb-0">Total Pelamar</p>
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
                <h5 class="mb-0">{{ $statistik['diterima'] }}</h5>
                <p class="mb-0">Diterima</p>
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
                <h5 class="mb-0">{{ $statistik['menunggu'] }}</h5>
                <p class="mb-0">Menunggu</p>
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
                <h5 class="mb-0">{{ $statistik['ditolak'] }}</h5>
                <p class="mb-0">Ditolak</p>
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
            <h5 class="mb-0">Daftar Lamaran Magang</h5>
        </div>

        <div class="row ms-3">
            <div class="col-md-3 mb-3">
                <form action="{{ route('admin.lamaran.index') }}" method="GET">
                    <div class="input-group">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-md-4 mb-3">
                <form action="{{ route('admin.lamaran.index') }}" method="GET">
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

        <div class="card-body">
            <div class="table-responsive">
                <table id="lamaranTable" class="table table-bordered table-striped w-100">
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
                        @foreach ($lamaran as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <h6 class="mb-0">
                                                <a href="javascript:void(0)"
                                                    onclick="showDetailModal({{ $item->id_lamaran }}, 'mahasiswa')">
                                                    {{ $item->mahasiswa->nama }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">{{ $item->mahasiswa->nim }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0)"
                                        onclick="showDetailModal({{ $item->id_lamaran }}, 'lowongan')">
                                        <strong>{{ $item->lowongan->nama_posisi }}</strong><br>
                                    </a>
                                    <small class="text-muted">{{ $item->lowongan->perusahaan->nama_perusahaan }}</small>
                                </td>
                                <td>
                                    <a href="javascript:void(0)"
                                        onclick="showDetailModal({{ $item->id_lamaran }}, 'lamaran')">
                                        <span
                                            class="badge 
                        @if ($item->status_lamaran == 'diterima') bg-label-success 
                        @elseif($item->status_lamaran == 'ditolak') bg-label-danger 
                        @else bg-label-warning @endif">
                                            {{ ucfirst($item->status_lamaran) }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    @if ($item->status_lamaran == 'diterima')
                                        @if ($item->magang && $item->magang->dosenPembimbing)
                                            {{ $item->magang->dosenPembimbing->nama }}
                                        @else
                                            <span class="text-muted">(Belum ada dosen)</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_lamaran == 'menunggu')
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Setujui --}}
                                            <form action="{{ url('lamaran/' . $item->id_lamaran . '/status') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_lamaran" value="diterima">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bx bx-check"></i> Setujui
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak --}}
                                            <form action="{{ url('lamaran/' . $item->id_lamaran . '/status') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_lamaran" value="ditolak">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bx bx-x"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($item->status_lamaran == 'diterima')
                                        <button class="btn btn-sm btn-primary" 
                                            onclick="showPlotDosenModal({{ $item->id_lamaran }}, {{ optional($item->magang)->id_dosen_pembimbing }})">
                                            <i class="bx bx-user-plus"></i> {{ $item->magang && $item->magang->dosenPembimbing ? 'Ubah Dosen' : 'Plot Dosen' }}
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
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
                    <h5 class="modal-title" id="detailModalLabel">Detail Lamaran</h5>
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
                        <input type="hidden" name="status_lamaran" value="diterima">
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#lamaranTable').DataTable({
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Tidak ada data tersedia",
                    zeroRecords: "Tidak ada data ditemukan",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
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

        // Ketika modal ditutup, bersihkan pencarian Select2
        $('#plotDosenModal').on('hidden.bs.modal', function () {
            $('.select2-dosen').val(null).trigger('change');
        });

        // Fungsi untuk menampilkan modal plot dosen
        function showPlotDosenModal(lamaranId, dosenId = null) {
            const modal = $('#plotDosenModal');
            const form = $('#plotDosenForm');
            
            // Set form action
            form.attr('action', `/lamaran/${lamaranId}/status`);
            
            // Set selected dosen if provided
            const selectElement = $('#id_dosen_pembimbing');
            if (dosenId) {
                selectElement.val(dosenId).trigger('change');
            } else {
                selectElement.val(null).trigger('change');
            }
            
            modal.modal('show');
            
            // Fokus ke input pencarian setelah modal ditampilkan
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

            $.get(`/lamaran/${id}/${detail}`, function(data) {
                $('#modalBodyContent').html(data);
            }).fail(function() {
                $('#modalBodyContent').html(`
                    <div class="alert alert-danger">
                        Gagal memuat data lamaran. Silakan coba lagi.
                    </div>
                `);
            });
        }

        // Handle form submission for both status changes and dosen plotting
        $('form[action*="/status"]').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const actionText = form.find('input[name="status_lamaran"]').val() === 'diterima' ? 'menyetujui' : 'menolak';

            Swal.fire({
                title: 'Konfirmasi',
                text: `Anda yakin ingin ${actionText} lamaran ini?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary me-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || `Lamaran berhasil di${actionText}`,
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
                                text: xhr.responseJSON?.message ||
                                    `Terjadi kesalahan saat ${actionText} lamaran`
                            });
                        }
                    });
                }
            });
        });

        // Handle plot dosen form submission
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
    </script>
@endpush