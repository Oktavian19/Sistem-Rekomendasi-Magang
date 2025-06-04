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
                    <small id="error-edit_username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" id="edit_password" 
                           class="form-control">
                    <small id="error-edit_password" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Role</label>
                    <input type="text" class="form-control" value="{{ $user->role }}" disabled>
                    <input type="hidden" name="role" id="edit_role" value="{{ $user->role }}">
                </div>                

                {{-- Field Admin --}}
                @if ($user->role === 'admin')
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $detail->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $detail->email }}" required>
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
                        <input type="text" name="nim" id="nim" class="form-control" value="{{ $detail->nim }}" required>
                        <small id="error-nim" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $detail->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $detail->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control" value="{{ $detail->no_hp }}" required pattern="[0-9]*" inputmode="numeric" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Program Studi</label>
                        <select name="id_program_studi" id="id_program_studi" class="form-control" required>
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
                        <input type="text" name="nidn" id="nidn" class="form-control" value="{{ $detail->nidn }}" required>
                        <small id="error-nidn" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $detail->nama }}" required>
                        <small id="error-nama" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $detail->email }}" required>
                        <small id="error-email" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>No HP</label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control" value="{{ $detail->no_hp }}" required pattern="[0-9]*" inputmode="numeric" required>
                        <small id="error-no_hp" class="text-danger error-text"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bidang Minat</label>
                        <input type="text" name="bidang_minat" id="bidang_minat" class="form-control" value="{{ $detail->bidang_minat }}" required>
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

    // Custom rule: allowed email domain
    $.validator.addMethod("emailDomain", function (value, element, param) {
        let allowedDomains = param;
        let domain = value.split('@')[1];
        if (!domain) return false;

        return allowedDomains.some(function (allowed) {
            return domain.endsWith(allowed);
        });
    }, "Domain email tidak diperbolehkan.");

    $(document).ready(function () {
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
                required: false,
                minlength: 3,
                email: true,
                emailDomain: [".com", ".ac.id", ".co.id", ".org", ".net", ".info", ".biz", ".xyz"]
            },
            no_hp: {
                required: false,
                digits: true,
                minlength: 10,
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
            username: {
                required: "Username wajib diisi",
                minlength: "Username minimal 3 karakter",
            },
            password: {
                required: "Password wajib diisi",
                minlength: "Minimal 6 karakter jika ingin diubah"
            },
            nama: {
                required: "Nama wajib diisi",
                maxlength: "Maksimal 100 karakter"
            },
            email: {
                //required: "Email wajib diisi",
                minlength: "Email minimal 3 karakter",
                email: "Format email tidak sesuai",
                emailDomain: "Gunakan email dengan domain yang diperbolehkan (.com, .ac.id, dll)."
            },
            no_hp: {
                //required: "Nomor HP wajib diisi",
                digits: "Hanya boleh angka",
                minlength: "Minimal 10 karakter",
                maxlength: "Maksimal 20 karakter"
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
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        }

    });
});
    </script>
</form>