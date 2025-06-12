<form action="{{ url('program-studi/store-ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-program-studi" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Program Studi</label>
                    <input type="text" name="kode_program_studi" id="kode_program_studi" class="form-control" required>
                    <small id="error-kode_program_studi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Program Studi</label>
                    <input type="text" name="nama_program_studi" id="nama_program_studi" class="form-control" required>
                    <small id="error-nama_program_studi" class="error-text form-text text-danger"></small>
                </div>
            </div>
                
            <div class="modal-footer justify-content-start">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
    $("#form-tambah").validate({
        rules: {
            kode_program_studi: {
                required: true,
                maxlength: 10
            },
            nama_program_studi: {
                required: true,
                maxlength: 100
            }
        },
        messages: {
            kode_program_studi: {
                required: "Kode program studi wajib diisi wajib diisi.",
                maxlength: "Maksimal 10 karakter."
            },
            nama_program_studi: {
                required: "Nama program studi wajib diisi wajib diisi.",
                maxlength: "Maksimal 100 karakter."
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