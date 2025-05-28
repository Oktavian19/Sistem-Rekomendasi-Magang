<form action="{{ url('lowongan/store-ajax') }}" method="POST" id="form-tambah">
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
                    <label>Jenis Magang</label>
                    <select name="jenis_magang" id="jenis_magang" class="form-control" required>
                        <option value="">Pilih Jenis</option>
                        <option value="WFO">WFO</option>
                        <option value="WFH">WFH</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                    <small id="error-jenis_magang" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Bidang Keahlian</label>
                    <select name="id_bidang_keahlian" id="id_bidang_keahlian" class="form-control" required>
                        <option value="">Pilih Bidang Keahlian</option>
                        @foreach ($bidangKeahlians as $bidangKeahlian)
                            <option value="{{ $bidangKeahlian->id }}">{{ $bidangKeahlian->label }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_keahlian" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Jenis Pelaksanaan</label>
                    <select name="id_jenis_pelaksanaan" id="id_jenis_pelaksanaan" class="form-control" required>
                        <option value="">Pilih Jenis Pelaksanaan</option>
                        @foreach ($jenisPelaksanaans as $jenisPelaksanaan)
                            <option value="{{ $jenisPelaksanaan->id }}">{{ $jenisPelaksanaan->label }}</option>
                        @endforeach
                    </select>
                    <small id="error-jenis_pelaksanaan" class="error-text form-text text-danger"></small>
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
                        @foreach ($durasiMagang as $durasi)
                            <option value="{{ $durasi->id }}">{{ $durasi->label }}</option>
                        @endforeach
                    </select>
                    <small id="error-durasi_magang" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    // Tambahkan method untuk membandingkan tanggal tutup >= tanggal buka
    $.validator.addMethod("greaterThanOrEqual", function (value, element, param) {
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
                maxlength: 100
            },
            jenis_magang: {
                required: true
            },
            deskripsi: {
                required: true,
                maxlength: 1000
            },
            id_bidang_keahlian: {
                required: true,
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
                maxlength: "Maksimal 100 karakter."
            },
            jenis_magang: {
                required: "Silahkan pilih jenis magang."
            },
            deskripsi: {
                required: "Deskripsi wajib diisi.",
                maxlength: "Maksimal 1000 karakter."
            },
            kategori_keahlian: {
                required: "Kategori keahlian wajib diisi.",
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
            durasi_magang: {
                required: "Durasi magang wajib diisi.",
            }
        },
        errorPlacement: function (error, element) {
            let id = element.attr('id');
            $('#error-' + id).html(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
</form>