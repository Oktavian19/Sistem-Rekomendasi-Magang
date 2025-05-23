<form action="{{ url('perusahaan/store-ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-perusahaan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" required>
                    <small id="error-nama_perusahaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Bidang Industri</label>
                    <input type="text" name="bidang_industri" id="bidang_industri" class="form-control" required>
                    <small id="error-bidang_industri" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label >Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Telepon</label>
                    <input type="tel" name="telepon" id="telepon" class="form-control" required pattern="[0-9]*" inputmode="numeric" required>
                    <small id="error-telepon" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Logo (opsional)</label>
                    <input type="file" name="logo" id="logo" class="form-control" accept=".jpg, .jpeg, .png">
                    <small id="error-logo" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('telepon').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
    $(document).ready(function () {
    $("#form-tambah").validate({
        rules: {
            nama_perusahaan: {
                required: true,
                maxlength: 100
            },
            bidang_industri: {
                required: true,
                maxlength: 100
            },
            alamat: {
                required: true
            },
            email: {
                required: true,
                email: true,
                maxlength: 100
            },
            telepon: {
                required: true,
                maxlength: 20,
                digits: true
            },
            logo: {
                required: false,
                extension: "jpg|jpeg|png",
                filesize: 2048000
            }
        },
        messages: {
            nama_perusahaan: {
                required: "Nama perusahaan wajib diisi.",
                maxlength: "Maksimal 100 karakter."
            },
            bidang_industri: {
                required: "Bidang industri wajib diisi.",
                maxlength: "Maksimal 100 karakter."
            },
            alamat: {
                required: "Alamat wajib diisi."
            },
            email: {
                required: "Email wajib diisi.",
                email: "Format email tidak valid.",
                maxlength: "Maksimal 100 karakter."
            },
            telepon: {
                required: "Telepon wajib diisi.",
                maxlength: "Maksimal 20 digit.",
                digits: "Hanya angka yang diperbolehkan."
            },
            logo: {
                extension: "Hanya file jpg, jpeg, atau png.",
                filesize: "Ukuran maksimal 2MB."
            }
        },
        errorPlacement: function(error, element) {
            $('#error-' + element.attr('name')).html(error);
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

   // Custom rule: file size
    $.validator.addMethod("filesize", function (value, element, param) {
        if (element.files.length === 0) {
            return true;
        }
        return element.files[0].size <= param;
    }, "File terlalu besar.");
});
    </script>
</form>