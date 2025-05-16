<form action="{{ url('user/store-ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-user" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Password</label>
                    <input type="text" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label >Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen_pembimbing">Dosen Pembimbing</option>
                    </select>
                    <small id="error-role" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    <small id="error-no_hp" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>

                {{-- Field Mahasiswa --}}
                <div id="form-mahasiswa" class="d-none">
                    <div class="form-group mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control">
                        <small class="text-danger" id="error-nim"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Program Studi</label>
                        <select name="id_program_studi" id="program_studi" class="form-control">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach($programStudi as $prodi)
                                <option value="{{ $prodi->id_program_studi }}">{{ $prodi->nama_program_studi }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="error-id_program_studi"></small>
                    </div>
                </div>

                {{-- Field Dosen Pembimbing --}}
                <div id="form-dosen" class="d-none">
                    <div class="form-group mb-3">
                        <label>NIDN</label>
                        <input type="text" name="nidn" id="nidn" class="form-control">
                        <small class="text-danger" id="error-nidn"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bidang Minat</label>
                        <input type="text" name="bidang_minat" id="bidang_minat" class="form-control">
                        <small class="text-danger" id="error-bidang_minat"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    <script>
    // Tampilkan field tambahan berdasarkan role
    $(document).ready(function () {
        $('#role').on('change', function () {
            let role = $(this).val();
            $('#form-mahasiswa').toggleClass('d-none', role !== 'mahasiswa');
            $('#form-dosen').toggleClass('d-none', role !== 'dosen_pembimbing');
        });
    });
    </script>
</form>