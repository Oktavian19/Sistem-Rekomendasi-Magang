<form action="{{ url('program-studi/' . $programStudi->id_program_studi . '/update-ajax') }}" method="POST" id="form-edit">
    @csrf
    <div id="modal-edit-program-studi" class="modal-dialog modal-lg" role="document">
        <input type="hidden" name="id_program_studi" id="edit_id_program_studi" value="{{ $programStudi->id_program_studi }}">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title">Edit Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Program Studi</label>
                    <input type="text" name="kode_program_studi" id="edit_kode_program_studi" 
                           class="form-control" value="{{ $programStudi->kode_program_studi }}" required>
                    <small id="error-edit_kode_program_studi" class="error-text form-text text-danger"></small>
                </div>
          
                <div class="form-group">
                    <label>Nama Program Studi</label>
                    <input type="text" name="nama_program_studi" id="edit_nama_program_studi" 
                           class="form-control" value="{{ $programStudi->nama_program_studi }}" required>
                    <small id="error-edit_nama_program_studi" class="error-text form-text text-danger"></small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>