<form action="{{ url('lowongan/' . $lowongan->id_lowongan . '/update-ajax') }}" method="POST" id="form-edit">
    @csrf
    <div id="modal-edit-lowongan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title">Edit Lowongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Perusahaan</label>
                    <select name="id_perusahaan" id="edit_id_perusahaan" class="form-control" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id_perusahaan }}" {{ $perusahaan->id_perusahaan == $lowongan->id_perusahaan ? 'selected' : '' }}>
                                {{ $perusahaan->nama_perusahaan }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-edit_id_perusahaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_nama_posisi">Nama Posisi</label>
                    <input type="text" name="nama_posisi" id="edit_nama_posisi" 
                           class="form-control" value="{{ $lowongan->nama_posisi }}" required>
                    <small id="error-edit_nama_posisi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" 
                            class="form-control" required>{{ $lowongan->deskripsi }}</textarea>
                    <small id="error-edit_deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_kategori_keahlian">Kategori Keahlian</label>
                    <input type="text" name="kategori_keahlian" id="edit_kategori_keahlian" 
                           class="form-control" value="{{ $lowongan->kategori_keahlian }}" required>
                    <small id="error-edit_kategori_keahlian" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_kuota">Kuota</label>
                    <input type="number" name="kuota" id="edit_kuota" 
                           class="form-control" value="{{ $lowongan->kuota }}" required>
                    <small id="error-edit_kuota" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_persyaratan">Persyaratan</label>
                    <textarea name="persyaratan" id="edit_persyaratan" 
                           class="form-control" required>{{ $lowongan->persyaratan }}</textarea>
                    <small id="error-edit_persyaratan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_tanggal_buka">Tanggal Buka</label>
                    <input type="date" name="tanggal_buka" id="edit_tanggal_buka" 
                           class="form-control" value="{{ $lowongan->tanggal_buka }}" required>
                    <small id="error-edit_tanggal_buka" class="error-text form-text text-danger"></small>

                </div>
                <div class="form-group mb-3">
                    <label for="edit_tanggal_tutup">Tanggal Tutup</label>
                    <input type="date" name="tanggal_tutup" id="edit_tanggal_tutup" 
                           class="form-control" value="{{ $lowongan->tanggal_tutup }}" required>
                    <small id="error-edit_tanggal_tutup" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label for="edit_durasi_magang">Durasi Magang</label>
                    <input type="text" name="durasi_magang" id="edit_durasi_magang" 
                           class="form-control" value="{{ $lowongan->durasi_magang }}" required>
                    <small id="error-edit_durasi_magang" class="error-text form-text text-danger"></small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>