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
                    <label>Nama Program Studi</label>
                    <input type="text" name="nama_program_studi" id="nama_program_studi" class="form-control" required>
                    <small id="error-nama_program_studi" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>