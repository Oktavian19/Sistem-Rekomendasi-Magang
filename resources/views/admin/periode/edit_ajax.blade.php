<form action="{{ url('periode/' . $periode->id_periode . '/update-ajax') }}" method="POST" id="form-edit">
    @csrf
    <div id="modal-edit-periode" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title">Edit Periode Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Nama Periode</label>
                    <input type="text" name="nama_periode" id="edit_nama_periode" 
                           class="form-control" value="{{ $periode->nama_periode }}" required>
                    <small id="error-edit_nama_periode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" 
                           class="form-control" value="{{ $periode->tanggal_mulai }}" required>
                    <small id="error-edit_tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" 
                           class="form-control" value="{{ $periode->tanggal_selesai }}" required>
                    <small id="error-edit_tanggal_selesai" class="error-text form-text text-danger"></small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
    $("#form-edit").validate({
        rules: {
            nama_periode: {
                required: true,
                maxlength: 100
            },
            tanggal_mulai: {
                required: true,
                date: true
            },
            tanggal_selesai: {
                required: true,
                date: true,
                greaterThanOrEqual: "#tanggal_mulai"
            }
        },
        messages: {
            nama_periode: {
                required: "Nama periode wajib diisi.",
                maxlength: "Nama periode maksimal 100 karakter."
            },
            tanggal_mulai: {
                required: "Tanggal mulai wajib diisi.",
                date: "Format tanggal mulai tidak valid."
            },
            tanggal_selesai: {
                required: "Tanggal selesai wajib diisi.",
                date: "Format tanggal selesai tidak valid.",
                greaterThanOrEqual: "Tanggal selesai harus setelah atau sama dengan tanggal mulai."
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
    
    // Custom method untuk validasi tanggal_selesai >= tanggal_mulai
    $.validator.addMethod("greaterThanOrEqual", function (value, element, param) {
        let startDate = $(param).val();
        if (!value || !startDate) return true;
        return new Date(value) >= new Date(startDate);
    }, "Tanggal harus lebih besar atau sama dengan tanggal mulai.");
});        
    </script>
</form>