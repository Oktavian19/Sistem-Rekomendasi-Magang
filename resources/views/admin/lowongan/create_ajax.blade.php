<form action="{{ url('lowongan/store-ajax') }}" method="POST" id="form-tambah">
    <style>
        .select2-container {
            z-index: 99999 !important;
        }

        .modal-open .select2-dropdown {
            z-index: 99999 !important;
        }
    </style>
    @csrf
    <div id="modal-lowongan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Lowongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Nama Perusahaan</label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id_perusahaan }}">{{ $perusahaan->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_perusahaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Nama Posisi</label>
                    <input type="text" name="nama_posisi" id="nama_posisi" class="form-control" required>
                    <small id="error-nama_posisi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Bidang Keahlian</label>
                    <select name="id_bidang_keahlian[]" class="form-select select2" multiple required>
                        <option value="">Pilih Bidang Keahlian</option>
                        @foreach ($bidangKeahlians as $bidangKeahlian)
                            <option value="{{ $bidangKeahlian->id }}">{{ $bidangKeahlian->label }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_bidang_keahlian" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Jenis Pelaksanaan</label>
                    <select name="id_jenis_pelaksanaan" id="id_jenis_pelaksanaan" class="form-control" required>
                        <option value="">Pilih Jenis Pelaksanaan</option>
                        @foreach ($jenisPelaksanaans as $jenisPelaksanaan)
                            <option value="{{ $jenisPelaksanaan->id }}">{{ $jenisPelaksanaan->label }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_pelaksanaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Kuota</label>
                    <input type="number" name="kuota" id="kuota" class="form-control" required>
                    <small id="error-kuota" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Persyaratan</label>
                    <textarea name="persyaratan" id="persyaratan" class="form-control" required></textarea>
                    <small id="error-persyaratan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Buka</label>
                    <input type="date" name="tanggal_buka" id="tanggal_buka" class="form-control" required>
                    <small id="error-tanggal_buka" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Tutup</label>
                    <input type="date" name="tanggal_tutup" id="tanggal_tutup" class="form-control" required>
                    <small id="error-tanggal_tutup" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Durasi Magang</label>
                    <select name="id_durasi_magang" id="id_durasi_magang" class="form-control" required>
                        <option value="">Pilih Durasi Magang</option>
                        @foreach ($durasiMagangs as $durasi)
                            <option value="{{ $durasi->id }}">{{ $durasi->label }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_durasi_magang" class="error-text form-text text-danger"></small>
                </div>
                <div class="col-lg-12 mb-4">
                    <div class="form-group">
                        <label>Fasilitas</label>
                        <select class="form-select select2" name="id_fasilitas[]" multiple>
                            @foreach ($fasilitas as $fasilitasItem)
                                <option value="{{ $fasilitasItem->id }}">{{ $fasilitasItem->label }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_fasilitas" class="error-text form-text text-danger"></small>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.validator.addMethod("greaterThanOrEqual", function(value, element, param) {
                let startDate = $(param).val();
                if (!value || !startDate) return true;
                return new Date(value) >= new Date(startDate);
            }, "Tanggal tutup harus setelah atau sama dengan tanggal buka.");

            $("#form-tambah").validate({
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
                        greaterThanOrEqual: "#tanggal_buka"
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

            $('#myModal').on('shown.bs.modal', function() {
                $('select[name="id_fasilitas[]"]').select2({
                    dropdownParent: $(this).find('.modal-content'),
                    width: '100%',
                    placeholder: "Pilih Fasilitas",
                    allowClear: true
                });
                $('select[name="id_bidang_keahlian[]"]').select2({
                    dropdownParent: $(this).find('.modal-content'),
                    width: '100%',
                    placeholder: "Pilih Bidang Keahlian",
                    allowClear: true
                });
            });
        });
    </script>
</form>
