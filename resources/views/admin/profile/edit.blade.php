@extends('layouts.app')

@section('title', 'Edit Profil | Sistem Rekomendasi Magang')

@section('content')
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-body" style="padding-top: 6vh; padding-bottom: 6vh;">
                <h4 class="mb-4 text-center fw-bold">Edit Profil Admin</h4>

                <form action="{{ url('profile/update-admin') }}" method="POST" enctype="multipart/form-data" id="form-edit" class="validate">
                    @csrf
                    @method('PUT')

                    <div class="col-lg-6 mb-4">
                        @if (!empty($admin->foto_profil))
                            <img src="{{ $admin->foto_profil }}" class="rounded-circle mb-2" id="preview-foto"
                                style="width: 100px; height: 100px; object-fit: cover;" alt="User">
                        @else
                            <img src="" class="rounded-circle mb-2 d-none" id="preview-foto"
                                style="width: 100px; height: 100px; object-fit: cover;" alt="Preview">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white mb-2"
                                style="width: 100px; height: 100px;" id="placeholder-icon">
                                <i class="bi bi-person" style="font-size: 60px;"></i>
                            </div>
                        @endif
                        <div>
                            <label for="foto_profil" class="form-label">Ubah Foto Profil</label>
                            <input type="file" class="form-control" name="foto_profil" id="foto_profil" accept="image/jpg, image/jpeg, image/png">
                            <small id="error-foto_profil" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama', $admin->nama) }}"
                            required>
                        <small id="error-nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $admin->email) }}"
                            required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="tel" class="form-control" name="no_hp" id="no_hp" value="{{ old('no_hp', $admin->no_hp) }}"
                        required pattern="[0-9]*" inputmode="numeric">
                        <small id="error-no_hp" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ url('/profile') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('no_hp').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Preview Foto Profil
        $('#foto_profil').on('change', function (e) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            if (file) {
                reader.onload = function (e) {
                    $('#preview-foto').attr('src', e.target.result).removeClass('d-none');
                    $('#placeholder-icon').addClass('d-none');
                }
                reader.readAsDataURL(file);
            }
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
    
    
        // Custom rule: file size
        $.validator.addMethod("filesize", function(value, element, param) {
            if (element.files.length === 0) {
                return true;
            }
            return element.files[0].size <= param;
        }, "File terlalu besar.");
    
        $(document).ready(function () {
        $("#form-edit").validate({
            rules: {
                foto_profil: {
                    required: false,
                    extension: "jpg|jpeg|png",
                    filesize: 2048000
                },
                nama: {
                    required: true,
                    maxlength: 100
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 3,
                    emailDomain: [".com", ".ac.id", ".co.id", ".org", ".net", ".info", ".biz", ".xyz"]
                },
                no_hp: {
                    required: true,
                    maxlength: 20,
                    minlength: 10,
                    digits: true
                }
            },
            messages: {
                foto_profil: {
                    extension: "Hanya file jpg, jpeg, atau png.",
                    filesize: "Ukuran maksimal 2MB."
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
    });
    </script>
@endpush