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

                <div class="col-lg-12 mb-4 d-flex flex-column align-items-center justify-content-center text-center">
                    @if (!empty($mahasiswa->foto_profil))
                        <img src="{{ $mahasiswa->foto_profil }}" class="rounded-circle mb-3" id="preview-foto"
                            style="width: 100px; height: 100px; object-fit: cover;" alt="User">
                    @else
                        <img src="" class="rounded-circle mb-2 d-none" id="preview-foto"
                            style="width: 100px; height: 100px; object-fit: cover;" alt="Preview">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white mb-3"
                            style="width: 100px; height: 100px;" id="placeholder-icon">
                            <i class="bi bi-person" style="font-size: 60px;"></i>
                        </div>
                    @endif

                    <div class="w-100 text-center">
                        <label for="foto_profil" class="form-label">Ubah Foto Profil</label>
                        <input type="file" class="form-control mx-auto" style="max-width: 300px;" name="foto_profil"
                            id="foto_profil" accept="image/*">
                        <small id="error-foto_profil" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-sm" name="nama" id="nama"
                                placeholder="Masukkan Nama Lengkap" value="{{ old('nama', $mahasiswa->nama) }}"
                                autocomplete="off" required>
                            <small id="error-nama" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" id="email"
                                placeholder="Masukkan Email" value="{{ old('email', $mahasiswa->email) }}"
                                autocomplete="off" required>
                            <small id="error-email" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">No Telepon</label>
                            <input type="text" class="form-control form-control-sm" name="no_hp" id="no_hp"
                                placeholder="Masukkan No Telepon" value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                                autocomplete="off" required>
                            <small id="error-no_hp" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="required form-label">Program Studi</label>
                            <select name="id_program_studi" id="id_program_studi" class="form-control form-control-sm" required>
                                @foreach ($programStudi as $program)
                                    <option value="{{ $program->id_program_studi }}"
                                        {{ old('id_program_studi', $mahasiswa->id_program_studi) == $program->id_program_studi ? 'selected' : '' }}>
                                        {{ $program->nama_program_studi }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-id_program_studi" class="text-danger error-text"></small>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control form-control-sm" name="alamat" id="alamat" placeholder="Masukkan Alamat" autocomplete="off"
                                rows="3">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                            <small id="error-alamat" class="text-danger error-text"></small>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label class="required form-label">Fasilitas yang Diinginkan</label>
                        <select class="form-select form-select-sm" name="fasilitas[]" id="fasilitas" data-control="select2"
                            data-allow-clear="true" data-placeholder="Pilih Fasilitas Magang" multiple="multiple">
                            @foreach ($fasilitas as $f)
                                <option value="{{ $f->id }}" @selected(in_array($f->id, old('fasilitas', optional($mahasiswa->opsiPreferensi)->pluck('id')->toArray() ?? [])))>
                                    {{ $f->label }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-fasilitas" class="text-danger error-text"></small>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label class="required form-label">Bidang Keahlian</label><br>
                        <small class="text-muted">Urutkan Berdasarkan Preferensi Anda</small>
                        <select id="select-bidang-keahlian" name="select_bidang_keahlian" class="form-select form-select-sm" data-control="select2"
                            data-placeholder="Pilih Bidang Keahlian">
                            <option></option>
                            @foreach ($bidangKeahlian as $bidang)
                                <option value="{{ $bidang->id }}">{{ $bidang->label }}</option>
                            @endforeach
                        </select>
                        <small id="error-bidang_keahlian" class="text-danger error-text"></small>
                        <ul id="sortable-bidang-keahlian" class="list-group mt-2">
                            @foreach (old('bidang_keahlian', optional($mahasiswa->opsiPreferensi)->pluck('id')->toArray() ?? []) as $id)
                                @php $item = $bidangKeahlian->firstWhere('id', $id); @endphp
                                @if ($item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center"
                                        data-id="{{ $item->id }}">
                                        <span class="rank me-2">#1</span>
                                        <span class="text-start flex-grow-1">{{ $item->label }}</span>
                                        <button type="button" class="btn btn-sm btn-danger remove-item">×</button>
                                        <input type="hidden" name="bidang_keahlian[]" value="{{ $item->id }}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        @error('bidang_keahlian')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label class="required form-label">Preferensi Jenis Perusahaan</label><br>
                        <small class="text-muted">Urutkan Berdasarkan Preferensi Anda</small>
                        <ul id="sortable-perusahaan" class="list-group">
                            @foreach (old('jenis_perusahaan', optional($mahasiswa->opsiPreferensi)->pluck('id')->toArray() ?? []) as $id)
                                @php $item = $jenisPerusahaan->firstWhere('id', $id); @endphp
                                @if ($item)
                                    <li class="list-group-item d-flex align-items-center justify-content-between" data-id="{{ $item->id }}">
                                        <div>
                                            <span class="rank me-2">#1</span>
                                            <span>{{ $item->label }}</span>
                                        </div>
                                        <input type="hidden" name="jenis_perusahaan[]" value="{{ $item->id }}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    {{-- ===== Lokasi Magang (Jarak) (Hanya Urutkan) ===== --}}
                    <div class="col-lg-6 mb-4">
                        <label class="required form-label">Preferensi Lokasi Magang</label><br>
                        <small class="text-muted">Urutkan Berdasarkan Preferensi Anda</small>
                        <ul id="sortable-jarak" class="list-group">
                            @foreach (old('jarak', optional($mahasiswa->opsiPreferensi)->pluck('id')->toArray() ?? []) as $id)
                                @php $item = $jarak->firstWhere('id', $id); @endphp
                                @if ($item)
                                    <li class="list-group-item d-flex align-items-center justify-content-between" data-id="{{ $item->id }}">
                                        <div>
                                            <span class="rank me-2">#1</span>
                                            <span>{{ $item->label }}</span>
                                        </div>
                                        <input type="hidden" name="jarak[]" value="{{ $item->id }}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    {{-- ===== Durasi Magang (Hanya Urutkan) ===== --}}
                    <div class="col-lg-6 mb-4">
                        <label class="required form-label">Preferensi Durasi Magang</label><br>
                        <small class="text-muted">Urutkan Berdasarkan Preferensi Anda</small>
                        <ul id="sortable-durasi" class="list-group">
                            @foreach (old('durasi_magang', optional($mahasiswa->opsiPreferensi)->pluck('id')->toArray() ?? []) as $id)
                                @php $item = $durasi->firstWhere('id', $id); @endphp
                                @if ($item)
                                    <li class="list-group-item d-flex align-items-center justify-content-between" data-id="{{ $item->id }}">
                                        <div>
                                            <span class="rank me-2">#1</span>
                                            <span>{{ $item->label }}</span>
                                        </div>
                                        <input type="hidden" name="durasi[]" value="{{ $item->id }}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
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
                                                {{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
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
                                        {{ \Carbon\Carbon::parse($pengalaman->tanggal_mulai)->locale('id')->isoFormat('MMMM YYYY') }} -
                                        {{ $pengalaman->tanggal_selesai ? \Carbon\Carbon::parse($pengalaman->tanggal_selesai)->locale('id')->isoFormat('MMMM YYYY') : 'Sekarang' }}
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.getElementById('no_hp').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Preview Foto Profil
        $('#foto_profil').on('change', function (e) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            if (file) {
                reader.onload = function (e) {
                    $('#preview-foto').attr('src', e.target.result).removeClass('d-none');
                    $('#placeholder-icon').addClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    
        // Custom rule: allowed email domain
        $.validator.addMethod("emailDomain", function (value, element, param) {
            let allowedDomains = param;
            let domain = value.split('@')[1];
            if (!domain) return false;
    
            return allowedDomains.some(function (allowed) {
                return domain.endsWith(allowed);
            });
        }, "Domain email tidak diperbolehkan.");
    
    
        // Custom rule: file size
        $.validator.addMethod("filesize", function(value, element, param) {
            if (element.files.length === 0) {
                return true;
            }
            return element.files[0].size <= param;
        }, "File terlalu besar.");

        // Custom method untuk minimal jumlah input
        $.validator.addMethod("minSelected", function (value, element, params) {
            return $('#sortable-bidang-keahlian li').length >= params;
        }, "Pilih setidaknya {0} bidang keahlian.");

        $.validator.addMethod("minFasilitas", function (value, element, params) {
            return $('#fasilitas').val() && $('#fasilitas').val().length >= params;
        }, "Pilih setidaknya {0} fasilitas.")

        $(document).ready(function() {
            // Aktifkan select2 hanya untuk select yang masih digunakan
            $('[data-control="select2"]').select2({
                width: '100%',
            });

            $('#formUpdateProfile').submit(function(e) {
                e.preventDefault();

                // Cek validasi
                if (!$(this).valid()) {
                    return; // Berhenti kalau form tidak valid
                }

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
                        }).then(() => {
                            location.reload(); // Refresh seluruh halaman setelah alert selesai
                        });
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan.';

                        if (xhr.status === 422) {
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

            $("#formUpdateProfile").validate({
                rules: {
                    foto_profil: {
                        required: false,
                        extension: "jpg|jpeg|png",
                        filesize: 2048000
                    },
                    nama: {
                        required: true,
                        maxlength: 100
                    },
                    email: {
                        required: true,
                        email: true,
                        minlength: 3,
                        emailDomain: [".com", ".ac.id", ".co.id", ".org", ".net", ".info", ".biz", ".xyz"]
                    },
                    no_hp: {
                        required: true,
                        maxlength: 20,
                        minlength: 10,
                        digits: true
                    },
                    id_program_studi: {
                        required: true
                    },
                    alamat: {
                        required: true,
                        minlength: 3,
                    },
                    "fasilitas[]": {
                        minFasilitas: 1
                    },
                    select_bidang_keahlian: {
                        minSelected: 1
                    },
                },
                messages: {
                    foto_profil: {
                        extension: "Hanya file jpg, jpeg, atau png.",
                        filesize: "Ukuran maksimal 2MB."
                    },
                    nama: {
                        required: "Nama wajib diisi",
                        maxlength: "Maksimal 100 karakter"
                    },
                    email: {
                        required: "Email wajib diisi",
                        minlength: "Email minimal 3 karakter",
                        email: "Format email tidak sesuai",
                        emailDomain: "Gunakan email dengan domain yang diperbolehkan (.com, .ac.id, dll)."
                    },
                    no_hp: {
                        required: "Nomor HP wajib diisi",
                        digits: "Hanya boleh angka",
                        minlength: "Minimal 10 karakter",
                        maxlength: "Maksimal 20 karakter"
                    },
                    id_program_studi: {
                        required: "Program studi wajib untuk mahasiswa"
                    },
                    alamat: {
                        required: "Alamat wajib diisi",
                        minlength: "Minimal 3 karakter"
                    },
                    "fasilitas[]": {
                        required: "Pilih setidaknya 1 fasilitas.",
                        minFasilitas: "Pilih setidaknya 1 fasilitas."
                    },
                    select_bidang_keahlian: {
                        minSelected: "Pilih setidaknya 1 bidang keahlian."
                    }
                },
                errorElement: 'small',
                errorClass: 'text-danger text-sm',
                
                highlight: function(element, errorClass) {
                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container').find('.select2-selection')
                            .addClass('border border-danger');
                    } else {
                        $(element).addClass('is-invalid');
                    }
                },
                
                unhighlight: function(element, errorClass) {
                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container').find('.select2-selection')
                            .removeClass('border border-danger');
                    } else {
                        $(element).removeClass('is-invalid');
                    }
                },

                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2')); // taruh setelah select2
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });

        // Number Ranking
        $(function () {
            const sortableIds = ['perusahaan', 'jarak', 'durasi', 'bidang-keahlian'];

            sortableIds.forEach(function (id) {
                const selector = '#sortable-' + id;

                function updateRanks() {
                    $(selector + ' li').each(function (index) {
                        $(this).find('.rank').text('#' + (index + 1));
                    });
                }

                $(selector).sortable({
                    update: function () {
                        updateRanks();
                    }
                });

                updateRanks(); // set initial
            });
        });

        function updateRanks() {
            $('#sortable-bidang-keahlian li').each(function (index) {
                $(this).find('.rank').text('#' + (index + 1));
            });
        }

        $(document).on('click', '.remove-item', function () {
            $(this).closest('li').remove();
            updateRanks();
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
                    event.target.closest('form').submit();
                }
            });
        }

        // ===== SortableJS Setup =====
        function enableSortable(listId, inputName) {
            new Sortable(document.getElementById(listId), {
                animation: 150,
                onEnd: function(evt) {
                    const container = evt.to;
                    const items = container.querySelectorAll('li');
                    container.querySelectorAll('input[type="hidden"]').forEach(e => e.remove());
                    items.forEach(item => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = inputName + '[]';
                        input.value = item.getAttribute('data-id');
                        item.appendChild(input);
                    });
                }
            });
        }

        enableSortable('sortable-bidang-keahlian', 'bidang_keahlian');
        enableSortable('sortable-perusahaan', 'jenis_perusahaan'); // Tetap bisa diurutkan
        enableSortable('sortable-jarak', 'jarak');
        enableSortable('sortable-durasi', 'durasi');

        // Select2 hanya untuk bidang keahlian (jika masih pakai dynamic select)
        $('#select-bidang-keahlian').select2({
            allowClear: true,
            placeholder: 'Pilih Bidang Keahlian',
            width: '100%',
            minimumResultsForSearch: 1,
            language: {
                noResults: function() {
                    return "Tidak ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        });

        // Handler select dan remove hanya untuk bidang keahlian
        $('#select-bidang-keahlian').on('select2:select', function(e) {
            const id = e.params.data.id;
            const text = e.params.data.text;
            const list = $('#sortable-bidang-keahlian');
            
            if (list.find(`li[data-id="${id}"]`).length) return;
            
            list.append(`
            <li class="list-group-item d-flex justify-content-between align-items-center" data-id="${id}">
                <span class="rank me-2">#?</span>
                <span>${text}</span>
                <button type="button" class="btn btn-sm btn-danger remove-item">×</button>
                <input type="hidden" name="bidang_keahlian[]" value="${id}">
                </li>
                `);
                
            $(this).val(null).trigger('change');
            $("#select-bidang-keahlian").valid();
            updateRanks();
        });

        $('#fasilitas').on('change', function () {
            $(this).valid();
        });

        // Handler tombol hapus hanya untuk item dinamis seperti bidang keahlian
        $(document).on('click', '.remove-item', function() {
            $(this).closest('li').remove();
            $("#select-bidang-keahlian").valid();
        });
    </script>
@endpush
