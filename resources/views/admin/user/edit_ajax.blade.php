<form action="{{ url('user/' . $user->id_user . '/update-ajax') }}" method="POST" id="form-edit">
    @csrf
    <div id="modal-edit-user" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengguna: {{ ucfirst($user->role) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Username</label>
                    <input type="text" name="username"  id="edit_username"
                           class="form-control" value="{{ $user->username }}" required>
                    <small id="error-edit_nama_perusahaan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" id="wdir_password" 
                           class="form-control">
                    <small id="error-edit_password" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" id="edit_role" disabled>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ $role == $user->role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Field Admin --}}
                @if ($user->role === 'admin')
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $admin->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $admin->no_hp }}" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>

                {{-- Field Mahasiswa --}}
                @elseif ($user->role === 'mahasiswa')
                    <div class="form-group mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" required>
                        <small id="error-nim" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $mahasiswa->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $mahasiswa->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $mahasiswa->no_hp }}" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Program Studi</label>
                        <select name="id_program_studi" class="form-control" required>
                            <option value="">Pilih Program Studi</option>
                            @foreach ($programStudi as $prodi)
                                <option value="{{ $prodi->id_program_studi }}" {{ $prodi->id_program_studi == $mahasiswa->id_program_studi ? 'selected' : '' }}>
                                    {{ $prodi->nama_program_studi }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_program_studi" class="text-danger error-text"></small>
                    </div>

                {{-- Field Dosen Pembimbing --}}
                @elseif ($user->role === 'dosen_pembimbing')
                    <div class="form-group mb-3">
                        <label>NIDN</label>
                        <input type="text" name="nidn" class="form-control" value="{{ $dosen_pembimbing->nidn }}" required>
                        <small id="error-nidn" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $dosen_pembimbing->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $dosen_pembimbing->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $dosen_pembimbing->no_hp }}" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bidang Minat</label>
                        <input type="text" name="bidang_minat" class="form-control" value="{{ $dosen_pembimbing->bidang_minat }}" required>
                        <small id="error-bidang_minat" class="text-danger error-text"></small>
                    </div>
                @endif
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>