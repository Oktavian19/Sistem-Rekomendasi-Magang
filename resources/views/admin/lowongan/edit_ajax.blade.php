<form action="{{ url('lowongan/' . $lowongan->id_lowongan . '/update-ajax') }}" method="POST" id="form-edit">
    <style>
        .select2-container {
            z-index: 99999 !important;
        }

        .modal-open .select2-dropdown {
            z-index: 99999 !important;
        }
    </style>
    @csrf
    <div id="modal-edit-lowongan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Lowongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Nama Perusahaan</label>
                    <select name="id_perusahaan" id="edit_id_perusahaan" class="form-control" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id_perusahaan }}"
                                {{ $perusahaan->id_perusahaan == $lowongan->id_perusahaan ? 'selected' : '' }}>
                                {{ $perusahaan->nama_perusahaan }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-edit_id_perusahaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Nama Posisi</label>
                    <input type="text" name="nama_posisi" id="edit_nama_posisi" class="form-control"
                        value="{{ $lowongan->nama_posisi }}" required>
                    <small id="error-edit_nama_posisi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control" required>{{ $lowongan->deskripsi }}</textarea>
                    <small id="error-edit_deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Bidang Keahlian</label>
                    <select name="id_bidang_keahlian[]" id="edit_id_bidang_keahlian" class="form-select select2"
                        multiple required>
                        @foreach ($bidangKeahlians as $bidangKeahlian)
                            <option value="{{ $bidangKeahlian->id }}"
                                {{ in_array($bidangKeahlian->id, $lowongan->bidangKeahlian->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $bidangKeahlian->label }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-edit_id_bidang_keahlian" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Jenis Pelaksanaan</label>
                    <select name="id_jenis_pelaksanaan" id="edit_id_jenis_pelaksanaan" class="form-control" required>
                        <option value="">Pilih Jenis Pelaksanaan</option>
                        @foreach ($jenisPelaksanaans as $jenisPelaksanaan)
                            <option value="{{ $jenisPelaksanaan->id }}"
                                {{ $jenisPelaksanaan->id == $lowongan->id_jenis_pelaksanaan ? 'selected' : '' }}>
                                {{ $jenisPelaksanaan->label }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-edit_id_jenis_pelaksanaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Kuota</label>
                    <input type="number" name="kuota" id="edit_kuota" class="form-control"
                        value="{{ $lowongan->kuota }}" required>
                    <small id="error-edit_kuota" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Persyaratan</label>
                    <textarea name="persyaratan" id="edit_persyaratan" class="form-control" required>{{ $lowongan->persyaratan }}</textarea>
                    <small id="error-edit_persyaratan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Buka</label>
                    <input type="date" name="tanggal_buka" id="edit_tanggal_buka" class="form-control"
                        value="{{ $lowongan->tanggal_buka }}" required>
                    <small id="error-edit_tanggal_buka" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Tutup</label>
                    <input type="date" name="tanggal_tutup" id="edit_tanggal_tutup" class="form-control"
                        value="{{ $lowongan->tanggal_tutup }}" required>
                    <small id="error-edit_tanggal_tutup" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Durasi Magang</label>
                    <select name="id_durasi_magang" id="edit_id_durasi_magang" class="form-control" required>
                        <option value="">Pilih Durasi Magang</option>
                        @foreach ($durasiMagangs as $durasi)
                            <option value="{{ $durasi->id }}"
                                {{ $durasi->id == $lowongan->id_durasi_magang ? 'selected' : '' }}>
                                {{ $durasi->label }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-edit_id_durasi_magang" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Fasilitas</label>
                    <select class="form-select select2" name="id_fasilitas[]" multiple>
                        @foreach ($fasilitas as $fasilitasItem)
                            <option value="{{ $fasilitasItem->id }}"
                                {{ in_array($fasilitasItem->id, $lowongan->fasilitas->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $fasilitasItem->label }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-edit_id_fasilitas" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('select[name="id_fasilitas[]"]').select2({
                dropdownParent: $('#modal-edit-lowongan .modal-content'),
                width: '100%',
                placeholder: "Pilih Fasilitas",
                allowClear: true
            });

            $('select[name="id_bidang_keahlian[]"]').select2({
                dropdownParent: $('#modal-edit-lowongan .modal-content'),
                width: '100%',
                placeholder: "Pilih Bidang Keahlian",
                allowClear: true
            });

            $.validator.addMethod("greaterThanOrEqual", function(value, element, param) {
                let startDate = $(param).val();
                if (!value || !startDate) return true;
                return new Date(value) >= new Date(startDate);
            }, "Tanggal tutup harus setelah atau sama dengan tanggal buka.");

            $("#form-edit").validate({
                rules: {
                    id_perusahaan: {
                        required: true
                    },
                    nama_posisi: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    deskripsi: {
                        required: true,
                        maxlength: 1000
                    },
                    "id_bidang_keahlian[]": {
                        required: true
                    },
                    id_jenis_pelaksanaan: {
                        required: true,
                    },
                    kuota: {
                        required: true,
                        digits: true,
                        min: 1
                    },
                    persyaratan: {
                        required: true,
                        maxlength: 1000
                    },
                    tanggal_buka: {
                        required: true,
                        date: true
                    },
                    tanggal_tutup: {
                        required: true,
                        date: true,
                        greaterThanOrEqual: "#edit_tanggal_buka"
                    },
                    id_durasi_magang: {
                        required: true
                    }
                },
                messages: {
                    id_perusahaan: {
                        required: "Silakan pilih perusahaan."
                    },
                    nama_posisi: {
                        required: "Nama posisi wajib diisi.",
                        minlength: "Minimal 3 karakter.",
                        maxlength: "Maksimal 100 karakter."
                    },
                    deskripsi: {
                        required: "Deskripsi wajib diisi.",
                        maxlength: "Maksimal 1000 karakter."
                    },
                    "id_bidang_keahlian[]": {
                        required: "Pilih minimal satu bidang keahlian."
                    },
                    id_jenis_pelaksanaan: {
                        required: "Jenis pelaksanaan wajib diisi.",
                    },
                    kuota: {
                        required: "Kuota wajib diisi.",
                        digits: "Kuota harus berupa angka.",
                        min: "Minimal 1 kuota."
                    },
                    persyaratan: {
                        required: "Persyaratan wajib diisi.",
                        maxlength: "Maksimal 1000 karakter."
                    },
                    tanggal_buka: {
                        required: "Tanggal buka wajib diisi.",
                        date: "Format tanggal tidak valid."
                    },
                    tanggal_tutup: {
                        required: "Tanggal tutup wajib diisi.",
                        date: "Format tanggal tidak valid.",
                        greaterThanOrEqual: "Tanggal tutup harus setelah atau sama dengan tanggal buka."
                    },
                    id_durasi_magang: {
                        required: "Durasi magang wajib diisi.",
                    }
                },
                errorPlacement: function(error, element) {
                    let id = element.attr('id');
                    $('#error-' + id).html(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
