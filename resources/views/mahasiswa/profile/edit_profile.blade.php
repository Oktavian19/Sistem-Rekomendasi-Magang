@section('title', 'Edit Profile | Sistem Rekomendasi Magang')

@extends('layouts.app')

@section('content')
    <div class="card mb-5 border">
        <div class="card-header">
            <div class="card-title">
                <h4 class="fw-bold"><i class="bi bi-person text-dark fs-3 me-2"></i>Informasi Pribadi</h4>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" id="formUpdateProfile" action="{{ url('profile/update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-lg-6 mb-4">
                    @if (!empty($mahasiswa->foto_profil))
                        <img src="{{ $mahasiswa->foto_profil }}" class="rounded-circle mb-2"
                            style="width: 100px; height: 100px;" alt="User">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white mb-2"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-person" style="font-size: 60px;"></i>
                        </div>
                    @endif
                    <div>
                        <label for="foto_profil" class="form-label">Ubah Foto Profil</label>
                        <input type="file" class="form-control" name="foto_profil" id="foto_profil" accept="image/*">
                    </div>
                </div>
                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-sm" name="nama"
                                placeholder="Masukkan Nama Lengkap" value="{{ old('nama', $mahasiswa->nama) }}"
                                autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email"
                                placeholder="Masukkan Email" value="{{ old('email', $mahasiswa->email) }}"
                                autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">No Telepon</label>
                            <input type="text" class="form-control form-control-sm" name="no_hp"
                                placeholder="Masukkan No Telepon" value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                                autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Program Studi</label>
                            <select name="id_program_studi" class="form-control form-control-sm" required>
                                @foreach ($programStudi as $program)
                                    <option value="{{ $program->id_program_studi }}"
                                        {{ old('id_program_studi', $mahasiswa->id_program_studi) == $program->id_program_studi ? 'selected' : '' }}>
                                        {{ $program->nama_program_studi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control form-control-sm" name="alamat" placeholder="Masukkan Alamat" autocomplete="off">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Bidang Keahlian</label>
                            <select class="form-select form-select-sm" name="bidang_keahlian[]" data-control="select2"
                                data-allow-clear="true" data-placeholder="Pilih Bidang Keahlian">
                                @foreach ($bidangKeahlian as $bidang)
                                    <option value="{{ $bidang->id }}" @selected(in_array($bidang->id, old('bidang_keahlian', $mahasiswa->opsiPreferensi->pluck('id')->toArray() ?? [])))>
                                        {{ $bidang->label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_keahlian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Preferensi Jenis Perusahaan</label>
                            <select name="preferensi_perusahaan" class="form-control form-control-sm" required>
                                <option value="BUMN"
                                    {{ old('preferensi_perusahaan', $mahasiswa->preferensi_perusahaan ?? '') == 'BUMN' ? 'selected' : '' }}>
                                    BUMN</option>
                                <option value="Pemerintahan"
                                    {{ old('preferensi_perusahaan', $mahasiswa->preferensi_perusahaan ?? '') == 'Pemerintahan' ? 'selected' : '' }}>
                                    Pemerintahan</option>
                                <option value="Swasta"
                                    {{ old('preferensi_perusahaan', $mahasiswa->preferensi_perusahaan ?? '') == 'Swasta' ? 'selected' : '' }}>
                                    Swasta</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Preferensi Lokasi Magang</label>
                            <input type="text" class="form-control form-control-sm" name="preferensi_lokasi_magang"
                                placeholder="Mis: Malang, Jawa Timur" value="" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Preferensi Jenis Magang</label>
                            <select name="preferensi_magang" class="form-control form-control-sm" required>
                                <option value="WFO"
                                    {{ old('preferensi_magang', $mahasiswa->preferensi_magang ?? '') == 'WFO' ? 'selected' : '' }}>
                                    WFO</option>
                                <option value="WFH"
                                    {{ old('preferensi_magang', $mahasiswa->preferensi_magang ?? '') == 'WFH' ? 'selected' : '' }}>
                                    WFH</option>
                                <option value="Hybrid"
                                    {{ old('preferensi_magang', $mahasiswa->preferensi_magang ?? '') == 'Hybrid' ? 'selected' : '' }}>
                                    Hybrid</option>
                            </select>
                        </div>
                    </div>


                    <!-- Submit Buttons -->
                    <div class="col-lg-12 mt-4 text-end">
                        <a href="{{ url('/profile') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4"><i
                                class="fa fa-paper-plane me-2"></i>Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-5 border">
        <div class="border">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h4 class="fw-bold m-0">
                            <i class="bi bi-file-earmark-text text-dark fs-3 me-2"></i>Dokumen Pendukung
                        </h4>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-outline-primary btn-sm"
                            onclick="modalAction('{{ url('profile/dokumen/create') }}')">
                            <i class="fa fa-plus me-2"></i>Tambah Dokumen
                        </button>
                    </div>
                </div>
            </div>

            <!-- Documents List -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @php
                            $dokumenNonCV = $mahasiswa->dokumen->filter(function ($dokumen) {
                                return $dokumen->jenis_dokumen != 'cv';
                            });
                        @endphp

                        @if ($dokumenNonCV->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted">Belum ada dokumen yang diunggah</p>
                            </div>
                        @else
                            @foreach ($dokumenNonCV as $dokumen)
                                <!-- Document Item -->
                                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded">
                                    <div>
                                        <h5 class="fw-semibold mb-1">{{ $dokumen->jenis_dokumen }}</h5>
                                        <div class="d-flex align-items-center text-muted small">
                                            <span>Diunggah:
                                                {{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->format('d M Y') }}</span>
                                            <span class="bullet bg-gray-400 mx-2"></span>
                                            <span>
                                                <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank"
                                                    class="text-primary">
                                                    Lihat Dokumen
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button type="button"
                                            class="btn btn-icon btn-light-primary btn-sm me-2 btnEditDocument"
                                            onclick="modalAction('{{ url('profile/dokumen/' . $dokumen->id_dokumen . '/edit') }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ url('profile/dokumen', $dokumen->id_dokumen) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-light-danger btn-sm"
                                                onclick="confirmDelete(event)">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="card-title">
                    <h4 class="fw-bold m-0">
                        <i class="bi bi-briefcase text-dark fs-3 me-2"></i>Pengalaman
                    </h4>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-outline-primary btn-sm"
                        onclick="modalAction('{{ url('profile/pengalaman/create') }}')">
                        <i class="fa fa-plus me-2"></i>Tambah Pengalaman
                    </button>
                </div>
            </div>
        </div>

        <!-- Experience List -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @forelse ($mahasiswa->pengalamanKerja as $pengalaman)
                        <!-- Experience Item -->
                        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $pengalaman->nama_posisi }}</h5>
                                <div class="d-flex align-items-center text-muted small">
                                    <span>{{ $pengalaman->perusahaan }}</span>
                                    <span class="bullet bg-gray-400 mx-2"></span>
                                    <span>
                                        {{ \Carbon\Carbon::parse($pengalaman->tanggal_mulai)->format('M Y') }} -
                                        {{ $pengalaman->tanggal_selesai ? \Carbon\Carbon::parse($pengalaman->tanggal_selesai)->format('M Y') : 'Sekarang' }}
                                        ({{ $pengalaman->tanggal_selesai
                                            ? \Carbon\Carbon::parse($pengalaman->tanggal_mulai)->diff(\Carbon\Carbon::parse($pengalaman->tanggal_selesai))->format('%y tahun %m bulan')
                                            : \Carbon\Carbon::parse($pengalaman->tanggal_mulai)->diffForHumans(['parts' => 2, 'join' => true]) }})
                                    </span>
                                </div>
                                @if ($pengalaman->deskripsi)
                                    <div class="mt-2">
                                        <p class="mb-0">{{ $pengalaman->deskripsi }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-icon btn-light-primary btn-sm me-2 btnEdit"
                                    onclick="modalAction('{{ url('profile/pengalaman/' . $pengalaman->id_pengalaman . '/edit') }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ url('profile/pengalaman', $pengalaman->id_pengalaman) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-light-danger btn-sm"
                                        onclick="deleteExperience(event)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted">Belum ada pengalaman kerja</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#formUpdateProfile').submit(function(e) {
                e.preventDefault(); // Mencegah form submit default

                var form = $(this)[0];
                var formData = new FormData(form);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message || 'Data berhasil diperbarui!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan.';

                        if (xhr.status === 422) {
                            // Validasi Laravel
                            const errors = xhr.responseJSON.errors;
                            errorMsg = Object.values(errors).map(err => err.join(', ')).join(
                                '\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errorMsg,
                        });
                    }
                });
            });
        });

        function modalAction(url = '') {
            const modalEl = document.getElementById('myModal');
            const modalDialog = modalEl.querySelector('.modal-dialog');

            modalDialog.innerHTML = '';

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    modalDialog.innerHTML = html;

                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                })
                .catch(error => {
                    console.error('Error loading modal content:', error);
                });
        }

        function deleteExperience(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda ingin menghapus pengalaman ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.form.submit();
                }
            });
        }

        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Dokumen?',
                text: "Apakah Anda yakin ingin menghapus dokumen ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lanjutkan submit form jika dikonfirmasi
                    event.target.closest('form').submit();
                }
            });
        }
    </script>
@endpush
