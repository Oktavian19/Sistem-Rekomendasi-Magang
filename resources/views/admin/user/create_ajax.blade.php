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
                    <input type="password" name="password" id="password" class="form-control" required>
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
                    <input type="tel" name="no_hp" id="no_hp" class="form-control" required pattern="[0-9]*" inputmode="numeric" required>
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
            <div class="modal-footer justify-content-start">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
    $("#form-tambah").validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            password: {
                required: true,
                minlength: 6
            },
            role: {
                required: true
            },
            nama: {
                required: true,
                maxlength: 100
            },
            no_hp: {
                required: true,
                maxlength: 20,
                minlength: 10,
                digits: true
            },
            email: {
                required: true,
                email: true,
                minlength: 3,
                emailDomain: [".com", ".ac.id", ".co.id", ".org", ".net", ".info", ".biz", ".xyz"]
            },
            nim: {
                required: function () {
                    return $("#role").val() === "mahasiswa";
                }
            },
            id_program_studi: {
                required: function () {
                    return $("#role").val() === "mahasiswa";
                }
            },
            nidn: {
                required: function () {
                    return $("#role").val() === "dosen_pembimbing";
                }
            },
            bidang_minat: {
                required: function () {
                    return $("#role").val() === "dosen_pembimbing";
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
                required: "Email wajib diisi",
                minlength: "Email minimal 3 karakter",
                email: "Format email tidak sesuai",
                emailDomain: "Gunakan email dengan domain yang diperbolehkan (.com, .ac.id, dll)."
            },
            no_hp: {
                required: "Nomor HP wajib diisi",
                digits: "Hanya boleh angka",
                minlength: "Minimal 10 karakter",
                maxlength: "Maksimal 20 karakter"
            },
            nim: "NIM wajib diisi untuk mahasiswa",
            id_program_studi: "Program studi wajib dipilih untuk mahasiswa",
            nidn: "NIDN wajib diisi untuk dosen pembimbing",
            bidang_minat: "Bidang minat wajib diisi untuk dosen pembimbing"
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