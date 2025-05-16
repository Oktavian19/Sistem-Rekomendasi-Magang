<form action="{{ url('log-magang/' . $log->id . '/update') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-edit-log" class="modal-dialog modal-lg" role="document">
        <input type="hidden" name="id" id="edit_id" value="{{ $log->id }}">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title">Edit Log Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Date Input -->
                <div class="form-group mb-4">
                    <label>Tanggal</label>
                    <div class="input-group">
                        <input type="date" name="tanggal" id="edit_tanggal" 
                               class="form-control" value="{{ \Carbon\Carbon::parse($log->tanggal)->format('Y-m-d') }}" required>
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    </div>
                    <small id="error-edit_tanggal" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Description Input -->
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="8" required>{{ $log->deskripsi }}</textarea>
                    <small id="error-edit_deskripsi" class="error-text form-text text-danger"></small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>