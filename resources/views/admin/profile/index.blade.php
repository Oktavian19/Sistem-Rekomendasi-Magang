@extends('layouts.app')

@section('title', 'Profil | Sistem Rekomendasi Magang')

@section('content')
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-body" style="padding-top: 8vh; padding-bottom: 8vh;">
                <div class="d-flex flex-column align-items-center text-center mb-4">
                    @if (!empty($admin->foto_profil))
                        <img src="{{ $admin->foto_profil }}" class="rounded-circle" style="width: 100px; height: 100px;" alt="User">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-person" style="font-size: 60px;"></i>
                        </div>
                    @endif

                    <h2 class="fw-bold">{{ $admin->nama }}</h2>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope me-1"></i> Email
                        </label>
                        <input type="text" class="form-control" value="{{ $admin->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-telephone me-1"></i> No HP
                        </label>
                        <input type="text" class="form-control" value="{{ $admin->no_hp ?? '-' }}" disabled>
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
