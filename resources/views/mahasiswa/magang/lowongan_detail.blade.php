@section('title', 'Detail Lowongan | Sistem Rekomendasi Magang')

@extends('layouts.app')

@section('content')
    <section>
        <div class="container card" style="padding: 50px">
            <div class="row">
                <div class="col-lg-8 pe-lg-6">
                    <div class="row justify-content-between align-items-center mb-4">
                        <div class="col-xl-8 col-xxl-6">
                            <img src="{{ asset($lowongan->perusahaan->path_logo ?? 'storage/logo_perusahaan/logo-default.jpg') }}"
                                class="rounded" style="width:80px; height:80px" alt="Company Logo">

                            <h2 class="fw-bold">{{ $lowongan->nama_posisi }}</h2>
                            <div class="mb-3">
                                <a href="#"
                                    class="text-decoration-none">{{ $lowongan->perusahaan->nama_perusahaan }}</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center mt-3">
                                <form action="{{ url('lowongan/' . $lowongan->id_lowongan . '/daftar') }}" method="POST">
                                    @csrf
                                    {{-- Tambahkan input hidden dari_rekomendasi --}}
                                    <input type="hidden" name="dari_rekomendasi"
                                        value="{{ request('dari_rekomendasi', 0) }}">

                                    <button type="submit" class="btn btn-primary ms-2 rounded-pill"
                                        {{ $sudahDaftar ? 'disabled' : '' }}>
                                        {{ $sudahDaftar ? 'Sudah Terdaftar' : 'Daftar' }}
                                    </button>
                                </form>
                            </div>


                        </div>
                    </div>

                    <div class="row justify-content-between align-items-center mb-4">
                        <div class="col-auto mb-2">
                            <div>
                                <p class="text-muted mb-1">Total Pelamar</p>
                                <span class="fw-bold">{{$jumlahPelamar}}</span> {{-- Ganti sesuai kebutuhan --}}
                            </div>
                        </div>
                        <div class="col-auto mb-2">
                            <div>
                                <p class="text-muted mb-1">Pendaftaran</p>
                                <span
                                    class="fw-bold text-success">{{ \Carbon\Carbon::parse($lowongan->tanggal_buka)->locale('id')->isoFormat('D MMMM') }}</span>
                                -
                                <span
                                    class="fw-bold text-danger">{{ \Carbon\Carbon::parse($lowongan->tanggal_tutup)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="job-description mt-4">
                        <h4 class="mb-3">Deskripsi</h4>
                        <div class="text-muted">
                            {!! $lowongan->deskripsi !!}

                            <p><strong>Persyaratan:</strong></p>
                            {!! $lowongan->persyaratan !!}
                        </div>

                        <div class="alert alert-warning d-flex align-items-center mt-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                            <div>
                                <strong>Penting: Pendaftaran dan proses rekrutmen oleh perusahaan mitra sepenuhnya
                                    gratis...</strong>
                            </div>
                        </div>
                        <a style="margin-top: 10vh" href="{{ url('/daftar-lowongan') . '?' . (request()->except('page') ? '?' . http_build_query(request()->except('page')) : '') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Lowongan
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 ps-lg-6">
                    <div class="card border border-primary mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="text-muted small">Bidang Pekerjaan</div>
                                    <div class="fw-bold">
                                    @foreach ($lowongan->bidangKeahlian as $bidang)
                                        {{ $bidang->label ?? '-' }},
                                    @endforeach
                                    </div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Lokasi</div>
                                <div class="fw-bold">{{ $lowongan->perusahaan->alamat ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Kuota Pelamar</div>
                                <div class="fw-bold">{{ $lowongan->kuota }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card border border-primary">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <img src="{{ asset($lowongan->perusahaan->path_logo ?? 'storage/logo_perusahaan/logo-default.jpg') }}"
                                            class="rounded" style="width:80px; height:80px" alt="Company Logo">
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <div class="fw-bold fs-5">{{ $lowongan->perusahaan->lowongan()->count() }}</div>
                                        <div class="text-muted small">Lowongan</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h5 class="fw-bold">{{ $lowongan->perusahaan->nama_perusahaan }}</h5>
                                <p class="text-muted small">{{ $lowongan->perusahaan->alamat ?? '-' }}</p>
                            </div>

                            <hr>
                            <div class="mb-3">
                                <div class="text-muted small">Email</div>
                                <div class="fw-bold">{{ $lowongan->perusahaan->email ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Industri</div>
                                <div class="fw-bold">{{ $lowongan->perusahaan->bidang_industri ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Jml. Karyawan</div>
                                <div class="fw-bold">{{ $lowongan->perusahaan->jumlah_karyawan ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@if (session('success'))
    @push('scripts')
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#007bff',
                confirmButtonText: 'OK'
            });
        </script>
    @endpush
@endif
@if (session('error'))
@push('scripts')
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
    });
</script>
@endpush
@endif
