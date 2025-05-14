<form action="{{ url('lowongan/store-ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-lowongan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
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
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Kategori Keahlian</label>
                    <input type="text" name="kategori_keahlian" id="kategori_keahlian" class="form-control" required>
                    <small id="error-kategori_keahlian" class="error-text form-text text-danger"></small>
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
                    <input type="text" name="durasi_magang" id="durasi_magang" class="form-control" required>
                    <small id="error-durasi_magang" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>