@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Lamaran Magang</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
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
                    @foreach($lamaran as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="ms-3">
                                    <h6 class="mb-0">{{ $item->mahasiswa->nama }}</h6>
                                    <small class="text-muted">NIM: {{ $item->mahasiswa->nim }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $item->lowongan->nama_posisi }}</strong><br>
                            <small class="text-muted">{{ $item->lowongan->jenis_magang }} - {{ $item->lowongan->durasi_magang }}</small>
                        </td>
                        <td>
                            <span class="badge 
                                @if($item->status_lamaran == 'diterima') bg-label-success 
                                @elseif($item->status_lamaran == 'ditolak') bg-label-danger 
                                @else bg-label-warning @endif">
                                {{ ucfirst($item->status_lamaran) }}
                            </span>
                        </td>
                        <td>
                            <form class="dosen-form" action="{{ url('lamaran/' . $item->id_lamaran . '/update-dosen') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="dosen_pembimbing" class="form-select form-select-sm" 
                                    onchange="this.form.submit()"
                                    {{ $item->status_lamaran != 'diterima' ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach($dosenList as $dosen)
                                        <option value="{{ $dosen->id_dosen_pembimbing }}" 
                                            {{ $item->id_dosen_pembimbing == $dosen->id_dosen_pembimbing ? 'selected' : '' }}>
                                            {{ $dosen->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary" onclick="showDetailModal({{ $item->id_lamaran }})">
                                    <i class="bx bx-show"></i> Detail
                                </button>
                                
                                @if($item->status_lamaran == 'menunggu')
                                    <form action="{{ route('admin.lamaran.updateStatus', $item->id_lamaran) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status_lamaran" value="diterima">
                                        <button type="button" onclick="handleStatusForm(this.form, 'menyetujui')" class="btn btn-sm btn-success">
                                            <i class="bx bx-check"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.lamaran.updateStatus', $item->id_lamaran) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status_lamaran" value="ditolak">
                                        <button type="button" onclick="handleStatusForm(this.form, 'menolak')" class="btn btn-sm btn-danger">
                                            <i class="bx bx-x"></i> Tolak
                                        </button>
                                    </form>
                                @endif
                            </div>
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
                            // Reload halaman setelah alert ditutup
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message || `Terjadi kesalahan saat ${action} lamaran`
                        });
                    }
                });
            }
        });
    }

    // Handle form update dosen pembimbing
    $(document).ready(function() {
        $('.dosen-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const selectedDosen = $(form).find('select').val();
            
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Dosen pembimbing berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memperbarui dosen pembimbing'
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        });
    });

    function showDetailModal(id) {
        $('#modalBodyContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Memuat data...</p>
            </div>
        `);
        
        $('#detailModal').modal('show');
        
        $.get(`/lamaran/${id}`, function(data) {
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