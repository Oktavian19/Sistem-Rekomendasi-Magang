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
</form>