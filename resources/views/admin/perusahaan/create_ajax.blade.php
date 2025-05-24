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
    </script>
</form>