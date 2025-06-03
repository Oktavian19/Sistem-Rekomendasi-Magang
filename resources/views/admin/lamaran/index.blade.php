@extends('layouts.app')

@section('content')
<div class="card-stats">
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Total Pelamar</h6>
                <h3 class="fs-4 fw-bold">{{ $statistik['total'] }}</h3>                
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Diterima</h6>
                <h3 class="fs-4 fw-bold text-success">{{ $statistik['diterima'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Menunggu</h6>
                <h3 class="fs-4 fw-bold text-warning">{{ $statistik['menunggu'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="text-muted">Ditolak</h6>
                <h3 class="fs-4 fw-bold text-danger">{{ $statistik['ditolak'] }}</h3>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <form action="{{ route('admin.lamaran.index') }}" method="GET">
            <div class="input-group">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
        </form>
    </div>
</div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Lamaran Magang</h5>
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
                                    <small class="text-muted">{{ $item->lowongan->jenis_magang }} -
                                        {{ $item->lowongan->durasi_magang }}</small>
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
                                    @if ($item->status_lamaran == 'menunggu')
                                        <form action="{{ url('lamaran/' . $item->id_lamaran . '/status') }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="id_dosen_pembimbing" class="form-select form-select-sm"
                                                onchange="toggleSetujuiButton(this, {{ $item->id_lamaran }})"
                                                id="dosenSelect-{{ $item->id_lamaran }}" required>
                                                <option value="">-- Pilih Dosen --</option>
                                                @foreach ($dosenList as $dosen)
                                                    <option value="{{ $dosen->id_dosen_pembimbing }}"
                                                        {{ optional($item->magang)->id_dosen_pembimbing == $dosen->id_dosen_pembimbing ? 'selected' : '' }}>
                                                        {{ $dosen->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif($item->status_lamaran == 'diterima')
                                            @if ($item->magang && $item->magang->dosenPembimbing)
                                                {{ $item->magang->dosenPembimbing->nama }}
                                            @else
                                                <span class="text-muted">Belum ada dosen</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_lamaran == 'menunggu')
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Setujui --}}
                                            <form action="{{ url('lamaran/' . $item->id_lamaran . '/status') }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_lamaran" value="diterima">
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    id="setujuiBtn-{{ $item->id_lamaran }}"
                                                    {{ empty(optional($item->magang)->id_dosen_pembimbing) ? 'disabled' : '' }}>
                                                    <i class="bx bx-check"></i> Setujui
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak --}}
                                            <form action="{{ url('lamaran/' . $item->id_lamaran . '/status') }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_lamaran" value="ditolak">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bx bx-x"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
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

        function handleStatusForm(form, action) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: `Anda yakin ingin ${action} lamaran ini?`,
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
                    // Submit form jika konfirmasi
                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || `Lamaran berhasil di${action}`,
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
                                    `Terjadi kesalahan saat ${action} lamaran`
                            });
                        }
                    });
                }
            });
        }

        function toggleSetujuiButton(selectEl, lamaranId) {
            const btn = document.getElementById('setujuiBtn-' + lamaranId);
            if (btn) {
                btn.disabled = !selectEl.value;
            }
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
    </script>
@endpush
