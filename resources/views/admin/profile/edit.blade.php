@extends('layouts.app')

@section('title', 'Edit Profil | Sistem Rekomendasi Magang')

@section('content')
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-body" style="padding-top: 6vh; padding-bottom: 6vh;">
                <h4 class="mb-4 text-center fw-bold">Edit Profil Admin</h4>

                <form action="{{ url('profile/update-admin') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-lg-6 mb-4">
                        @if (!empty($admin->foto_profil))
                            <img src="{{ $admin->foto_profil }}" class="rounded-circle mb-2"
                                style="width: 100px; height: 100px;" alt="User">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white mb-2"
                                style="width: 100px; height: 100px;">
                                <i class="bi bi-person" style="font-size: 60px;"></i>
                            </div>
                        @endif
                        <div>
                            <label for="foto_profil" class="form-label">Ubah Foto Profil</label>
                            <input type="file" class="form-control" name="foto_profil" id="foto_profil" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="{{ old('nama', $admin->nama) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $admin->email) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp', $admin->no_hp) }}">
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
