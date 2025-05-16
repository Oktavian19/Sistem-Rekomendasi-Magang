<form action="{{ url('user/' . $user->id_user . '/update-ajax') }}" method="POST" id="form-edit">
    @csrf
    <div id="modal-edit-user" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title">Edit Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" id="edit_nama_perusahaan" 
                           class="form-control" value="{{ $user->nama_perusahaan }}" required>
                    <small id="error-edit_nama_perusahaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Bidang Industri</label>
                    <input type="text" name="bidang_industri" id="edit_bidang_industri" 
                           class="form-control" value="{{ $user->bidang_industri }}" required>
                    <small id="error-edit_bidang_industri" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="edit_alamat" 
                           class="form-control" value="{{ $user->alamat }}" required>
                    <small id="error-edit_alamat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="text" name="email" id="edit_email" 
                           class="form-control" value="{{ $user->email }}" required>
                    <small id="error-edit_email" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Telepon</label>
                    <input type="text" name="telepon" id="edit_telepon" 
                           class="form-control" value="{{ $user->telepon }}" required>
                    <small id="error-edit_telepon" class="error-text form-text text-danger"></small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>