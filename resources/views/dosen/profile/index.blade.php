@extends('layouts.app')

@section('title', 'Profil | Sistem Rekomendasi Magang')

@section('content')
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-body" style="padding-top: 8vh; padding-bottom: 8vh;">
                <div class="d-flex flex-column align-items-center text-center mb-4">
                    <img src="https://bucket.sdmdigital.id/dts-simonas/photo/a7c4e502-414b-4b2b-b130-ecdcb9a31a83.jpg"
                         class="rounded-circle mb-3" width="120" height="120" alt="Profile Image">
                    <h2 class="fw-bold">{{ $dosen->nama }}</h2>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-card-heading me-1"></i> NIDN
                        </label>
                        <input type="text" class="form-control" value="{{ $dosen->nidn }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope me-1"></i> Email
                        </label>
                        <input type="text" class="form-control" value="{{ $dosen->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-telephone me-1"></i> No HP
                        </label>
                        <input type="text" class="form-control" value="{{ $dosen->no_hp ?? '-' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-mortarboard me-1"></i> Bidang Minat
                        </label>
                        <input type="text" class="form-control" value="{{ $dosen->bidang_minat ?? '-' }}" disabled>
                    </div>
                </form>
            </div>
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
@endsection
