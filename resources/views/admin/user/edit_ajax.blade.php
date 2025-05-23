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
                    <select name="role" class="form-control" id="edit_role">
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
                        <input type="text" name="nama" class="form-control" value="{{ $detail->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $detail->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control" value="{{ $detail->no_hp }}" required pattern="[0-9]*" inputmode="numeric" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>

                {{-- Field Mahasiswa --}}
                @elseif ($user->role === 'mahasiswa')
                    <div class="form-group mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" value="{{ $detail->nim }}" required>
                        <small id="error-nim" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $detail->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $detail->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control" value="{{ $detail->no_hp }}" required pattern="[0-9]*" inputmode="numeric" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Program Studi</label>
                        <select name="id_program_studi" class="form-control" required>
                            <option value="">Pilih Program Studi</option>
                            @foreach ($programStudi as $prodi)
                                <option value="{{ $prodi->id_program_studi }}" {{ $prodi->id_program_studi == $detail->id_program_studi ? 'selected' : '' }}>
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
                        <input type="text" name="nidn" class="form-control" value="{{ $detail->nidn }}" required>
                        <small id="error-nidn" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $detail->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $detail->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control" value="{{ $detail->no_hp }}" required pattern="[0-9]*" inputmode="numeric" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bidang Minat</label>
                        <input type="text" name="bidang_minat" class="form-control" value="{{ $detail->bidang_minat }}" required>
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
    <script>
    $(document).on('click', '.btn-edit', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');
    $.get(url, function(response) {
        $('#modal-content').html(response);
        $('#editModal').modal('show');
    });
});
    document.getElementById('no_hp').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
    (document).ready(function () {
    $("#form-edit").validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            password: {
                minlength: 6
            },
            nama: {
                required: true,
                maxlength: 100
            },
            email: {
                required: true,
                email: true
            },
            no_hp: {
                required: true,
                digits: true,
                maxlength: 20
            },
            nim: {
                required: function () {
                    return $("#edit_role").val() === "mahasiswa";
                }
            },
            id_program_studi: {
                required: function () {
                    return $("#edit_role").val() === "mahasiswa";
                }
            },
            nidn: {
                required: function () {
                    return $("#edit_role").val() === "dosen_pembimbing";
                }
            },
            bidang_minat: {
                required: function () {
                    return $("#edit_role").val() === "dosen_pembimbing";
                }
            }
        },
        messages: {
            username: "Username minimal 3 karakter",
            password: "Minimal 6 karakter jika ingin diubah",
            nama: "Nama wajib diisi",
            email: "Email tidak valid",
            no_hp: {
                required: "Nomor HP wajib diisi",
                digits: "Hanya boleh angka"
            },
            nim: "NIM wajib untuk mahasiswa",
            id_program_studi: "Program studi wajib untuk mahasiswa",
            nidn: "NIDN wajib untuk dosen pembimbing",
            bidang_minat: "Bidang minat wajib untuk dosen pembimbing"
        },
        errorPlacement: function (error, element) {
            let id = element.attr("id");
            $("#error-" + id).html(error);
        },
    });
});
    </script>
</form>