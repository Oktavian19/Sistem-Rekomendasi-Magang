@extends('layouts.app')

@section('title', 'Dashboard | Sistem Rekomendasi Magang')

@section('content')
<div class="col-12 d-flex justify-content-start align-items-center">
    <div class="card text-center p-4 shadow-lg" style="width: 100vw; height: 80vh">
        <img src="{{ asset('sneat/assets/img/mahasiswa_kosong.png') }}" alt="Mahasiswa" style="height: 50vh;" class="mx-auto mb-3">
        <h3 class="mb-2 text-primary">Profilmu Masih Belum Lengkap</h3>
        <p class="text-muted mb-3">
            Yuk lengkapi profilmu terlebih dahulu agar sistem dapat merekomendasikan magang yang sesuai dengan minat dan preferensimu.
        </p>
        <a href="{{ url('profile') }}" class="btn btn-primary px-4 mx-auto mt-5">
            Lengkapi Profil Sekarang
        </a>
    </div>
</div>
@endsection
