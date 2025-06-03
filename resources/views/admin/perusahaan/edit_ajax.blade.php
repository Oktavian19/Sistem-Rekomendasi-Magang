<form action="{{ url('perusahaan/' . $perusahaan->id_perusahaan . '/update-ajax') }}" method="POST" id="form-edit">
    @csrf
    <div id="modal-edit-perusahaan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" id="edit_nama_perusahaan" class="form-control"
                        value="{{ $perusahaan->nama_perusahaan }}" required>
                    <small id="error-edit_nama_perusahaan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label>Jenis Perusahaan</label>
                    <select name="id_jenis_perusahaan" id="edit_id_jenis_perusahaan" class="form-control" required>
                        @foreach ($jenisPerusahaan as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ old('id_jenis_perusahaan', $perusahaan->id_jenis_perusahaan) == $jenis->id ? 'selected' : '' }}>
                                {{ ucfirst($jenis->label) }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-edit_id_jenis_perusahaan" class="error-text form-text text-danger"></small>
                </div>


                <div class="form-group mb-3">
                    <label>Bidang Industri</label>
                    <input type="text" name="bidang_industri" id="edit_bidang_industri" class="form-control"
                        value="{{ $perusahaan->bidang_industri }}" required>
                    <small id="error-edit_bidang_industri" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="edit_alamat" class="form-control"
                        value="{{ $perusahaan->alamat }}" required>
                    <small id="error-edit_alamat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="text" name="email" id="edit_email" class="form-control"
                        value="{{ $perusahaan->email }}" required>
                    <small id="error-edit_email" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Telepon</label>
                    <input type="tel" name="telepon" id="edit_telepon" class="form-control"
                        value="{{ $perusahaan->telepon }}" required pattern="[0-9]*" inputmode="numeric" required>
                    <small id="error-edit_telepon" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Logo (opsional)</label>

                    {{-- Preview Logo Lama --}}
                    @if ($perusahaan->path_logo)
                        <div class="mb-2">
                            <img id="logo-preview" src="{{ asset($perusahaan->path_logo) }}" alt="Logo Perusahaan"
                                style="max-height: 100px;">
                        </div>
                        {{-- Checkbox Hapus Logo --}}
                        <div class="form-check mb-2">
                            <input type="checkbox" name="hapus_logo" id="hapus_logo" class="form-check-input">
                            <label class="form-check-label" for="hapus_logo">Hapus Logo</label>
                        </div>
                    @else
                        {{-- Preview Logo Baru --}}
                        <div class="mb-2">
                            <img id="logo-preview" src="#" alt="Preview Logo Baru"
                                style="max-height: 100px; display: none;">
                        </div>
                    @endif

                    {{-- Input File Logo Baru --}}
                    <input type="file" name="logo" id="logo" class="form-control"
                        accept="image/jpg, image/jpeg, image/png">
                    <small id="error-logo" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('edit_telepon').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        // Preview logo setelah memilih file
        document.getElementById("logo").addEventListener("change", function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById("logo-preview");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.style.display = "none";
            }
        });

        document.getElementById('hapus_logo')?.addEventListener('change', function() {
            const preview = document.getElementById('logo-preview');
            const originalLogoSrc = preview?.getAttribute('src');
            const inputLogo = document.getElementById('logo');

            if (this.checked) {
                preview.style.display = 'none';
                inputLogo.value = ''; // Reset input file
            } else {
                if (originalLogoSrc && !inputLogo.files.length) {
                    preview.src = originalLogoSrc;
                    preview.style.display = 'block';
                }
            }
        });

    $(document).ready(function () {
        $("#form-edit").validate({
            rules: {
                nama_perusahaan: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                bidang_industri: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                alamat: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 100,
                    minlength: 3,
                    emailDomain: [".com", ".ac.id", ".co.id", ".org", ".net", ".info", ".biz", ".xyz"]
                },
                telepon: {
                    required: true,
                    maxlength: 20,
                    minlength: 10,
                    digits: true
                },
                logo: {
                    required: false,
                    extension: "jpg|jpeg|png",
                    filesize: 2048000
                }
            },
            messages: {
                nama_perusahaan: {
                    required: "Nama perusahaan wajib diisi.",
                    minlength: "Minimal 3 karakter.",
                    maxlength: "Maksimal 100 karakter."
                },
                bidang_industri: {
                    required: "Bidang industri wajib diisi.",
                    minlength: "Minimal 3 karakter.",
                    maxlength: "Maksimal 100 karakter."
                },
                alamat: {
                    required: "Alamat wajib diisi.",
                    minlength: "Minimal 3 karakter."
                },
                email: {
                    required: "Email wajib diisi.",
                    email: "Format email tidak valid.",
                    maxlength: "Maksimal 100 karakter.",
                    minlength: "Minimal 3 karakter.",
                    emailDomain: "Gunakan email dengan domain yang diperbolehkan (.com, .ac.id, dll)."
                },
                telepon: {
                    required: "Telepon wajib diisi.",
                    maxlength: "Maksimal 20 digit.",
                    minlength: "Minimal 10 digit.",
                    digits: "Hanya angka yang diperbolehkan."
                },
                logo: {
                    extension: "Format logo harus jpg, jpeg, atau png.",
                    filesize: "Ukuran logo maksimal 2MB."
                }
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

        // Custom rule: allowed email domain
        $.validator.addMethod("emailDomain", function(value, element, param) {
            let allowedDomains = param;
            let domain = value.split('@')[1];
            if (!domain) return false;

            return allowedDomains.some(function(allowed) {
                return domain.endsWith(allowed);
            });
        }, "Domain email tidak diperbolehkan.");

        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    nama_perusahaan: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    id_jenis_perusahaan: {
                        required: true
                    },
                    bidang_industri: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    alamat: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100,
                        emailDomain: [".com", ".ac.id", ".co.id", ".org", ".net", ".info", ".biz", ".xyz"]
                    },
                    telepon: {
                        required: true,
                        maxlength: 20,
                        digits: true
                    },
                    logo: {
                        required: false,
                        extension: "jpg|jpeg|png",
                        filesize: 2048000
                    }
                },
                messages: {
                    nama_perusahaan: {
                        required: "Nama perusahaan wajib diisi.",
                        minlength: "Minimal 3 karakter.",
                        maxlength: "Maksimal 100 karakter."
                    },
                    id_jenis_perusahaan: {
                        required: "Jenis perusahaan wajib dipilih."
                    },
                    bidang_industri: {
                        required: "Bidang industri wajib diisi.",
                        minlength: "Minimal 3 karakter.",
                        maxlength: "Maksimal 100 karakter."
                    },
                    alamat: {
                        required: "Alamat wajib diisi.",
                        minlength: "Minimal 3 karakter."
                    },
                    email: {
                        required: "Email wajib diisi.",
                        email: "Format email tidak valid.",
                        maxlength: "Maksimal 100 karakter.",
                        emailDomain: "Gunakan email dengan domain yang diperbolehkan (.com, .ac.id, dll)."
                    },
                    telepon: {
                        required: "Telepon wajib diisi.",
                        maxlength: "Maksimal 20 digit.",
                        digits: "Hanya angka yang diperbolehkan."
                    },
                    logo: {
                        extension: "Format logo harus jpg, jpeg, atau png.",
                        filesize: "Ukuran logo maksimal 2MB."
                    }
                },
                errorPlacement: function(error, element) {
                    let id = element.attr("id"); // gunakan ID, bukan name
                    $("#error-" + id).html(error);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                }
            });

            // custom rule untuk validasi ukuran file logo
            $.validator.addMethod("filesize", function(value, element, param) {
                if (element.files.length === 0) return true;
                return element.files[0].size <= param;
            }, "Ukuran file terlalu besar.");
        });
    </script>
</form>
