<!doctype html>

<html lang="en" class="layout-wide customizer-hide" data-assets-path="{{ asset('sneat/assets') }}/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Register - Sistem Rekomendasi Magang</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>

    <!-- Config -->
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('sneat/assets/img/logo.png') }}" alt="Logo"
                                        style="width: 40px">
                                </span>
                                <span class="app-brand-text demo text-heading fw-bold">SIMAGANG</span>
                            </a>
                        </div>
                        <!-- /Logo -->


                        <form id="formAuthentication" class="mb-6" method="POST" action="{{ url('/register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="tel" class="form-control" id="nim" name="nim"
                                    placeholder="Masukkan NIM" required autofocus />
                                <small id="error-nim" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan nama" required />
                                <small id="error-nama" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email" required />
                                <small id="error-email" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="Masukkan alamat" required />
                                <small id="error-alamat" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp"
                                    placeholder="Masukkan Nomor HP" required />
                                <small id="error-no_hp" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi" class="form-label">Program Studi</label>
                                <select name="id_program_studi" id="program_studi" class="form-control" required>
                                    <option value="">-- Pilih Prodi --</option>
                                    @foreach ($programStudi as $prodi)
                                        <option value="{{ $prodi->id_program_studi }}">
                                            {{ $prodi->nama_program_studi }}</option>
                                    @endforeach
                                </select>
                                <small id="error-program_studi" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="••••••••••" required />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                <small id="error-password" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="form-password-toggle mb-3">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation" placeholder="••••••••••" required />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                <small id="error-password_confirmation"
                                    class="error-text form-text text-danger"></small>
                            </div>
                            <button class="btn btn-primary d-grid w-100 mt-7" type="submit">Daftar</button>
                        </form>

                        <p class="text-center">
                            <span>Sudah punya akun?</span>
                            <a href="{{ route('login') }}">
                                <span>Login</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Register Card -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>

    <!-- Load SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <!-- Optional: GitHub button -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>
        $(document).ready(function() {
            $('#formAuthentication').on('submit', function(e) {
                e.preventDefault(); // Mencegah form submit biasa

                const form = $(this);
                const formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                text: 'Validasi akun akan dikirimkan ke email Anda.',
                                showConfirmButton: true
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validasi error dari server
                            const errors = xhr.responseJSON.errors;
                            let pesan = '';
                            $.each(errors, function(key, value) {
                                pesan += `- ${value[0]}\n`;
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan:\n' + pesan
                            });
                        } else {
                            alert('Terjadi kesalahan server. Coba lagi nanti.');
                        }
                    }
                });
            });
        });
        document.getElementById('no_hp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        document.getElementById('nim').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Custom rule: allowed email domain
        $.validator.addMethod("emailDomain", function(value, element, param) {
            let allowedDomains = param;
            let domain = value.split('@')[1];
            if (!domain) return false;

            return allowedDomains.some(function(allowed) {
                return domain.endsWith(allowed);
            });
        }, "Domain email tidak diperbolehkan.")

        $(document).ready(function() {
            $("#formAuthentication").validate({
                rules: {
                    nim: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    nama: {
                        required: true,
                        maxlength: 100
                    },
                    email: {
                        required: true,
                        minlength: 3,
                        email: true,
                        emailDomain: [".com", ".ac.id", ".co.id", ".org", ".net", ".info", ".biz", ".xyz"]
                    },
                    alamat: {
                        required: true,
                        minlength: 3
                    },
                    no_hp: {
                        required: true,
                        maxlength: 15,
                        minlength: 10,
                        digits: true
                    },
                    id_program_studi: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    nim: {
                        required: "NIM wajib diisi.",
                        minlength: "Minimal 8 karakter.",
                        maxlength: "Maksimal 20 karakter."
                    },
                    nama: {
                        required: "Nama wajib diisi.",
                        maxlength: "Maksimal 100 karakter."
                    },
                    email: {
                        required: "Email wajib diisi.",
                        minlength: "Minimal 3 karakter.",
                        email: "Format email tidak valid.",
                        emailDomain: "Gunakan email dengan domain yang diperbolehkan (.com, .ac.id, dll)."
                    },
                    alamat: {
                        required: "Alamat wajib diisi.",
                        minlength: "Minimal 3 karakter."
                    },
                    no_hp: {
                        required: "No HP wajib diisi.",
                        maxlength: "Maksimal 15 digit.",
                        minlength: "Minimal 10 digit.",
                        digits: "Hanya angka yang diperbolehkan."
                    },
                    id_program_studi: {
                        required: "Program Studi wajib dipilih"
                    },
                    password: {
                        required: "Password wajib diisi.",
                        minlength: "Password minimal 6 karakter."
                    },
                    password_confirmation: {
                        required: "Konfirmasi password wajib diisi.",
                        equalTo: "Konfirmasi password tidak sesuai."
                    }
                },
                errorPlacement: function(error, element) {
                    const id = element.attr("id");
                    $("#error-" + id).html(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>
