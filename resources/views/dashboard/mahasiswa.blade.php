@extends('layouts.app')

@section('title', 'Dashboard | Sistem Rekomendasi Magang')

@section('content')
    @push('styles')
        <style>
            .card {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            .card ul {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                position: relative;
                z-index: 1;
            }

            .card ul::before {
                content: "";
                position: absolute;
                top: 44px;
                left: 15px;
                right: 15px;
                height: 3px;
                background-color: #ececec;
                z-index: 0;
            }

            .card ul li {
                list-style: none;
                display: flex;
                flex-direction: column;
                align-items: center;
                margin: 0 40px;
                position: relative;
                z-index: 2;
            }

            .icons {
                font-size: 25px;
                color: #27548A;
                margin-bottom: 10px;
            }

            .label {
                font-family: sans-serif;
                font-size: 14px;
                font-weight: bold;
                color: #27548A;
                letter-spacing: 1px;
            }

            .step {
                height: 30px;
                width: 30px;
                border-radius: 50%;
                background-color: #bababa;
                display: grid;
                place-items: center;
                color: white;
                position: relative;
                cursor: pointer;
            }

            .step .awesome {
                display: none;
            }

            .step p {
                font-size: 18px;
            }

            .step.active {
                background-color: #27548A;
            }

            .step.active p {
                display: none;
            }

            .step.active .awesome {
                display: flex;
            }
        </style>
    @endpush
    <div class="col-12 mb-4">
        <div class="card">
            <div class="">
                <div class="card-body card-widget-separator">
                    <div class="d-flex justify-content-center align-items-center" style="padding: 20px">
                        <ul class="progress-bar-steps">
                            <li>
                                <i class="icons fa-solid fa-copy"></i>
                                <div class="step first {{ $progressBarStatus['step1_active'] ?? false ? 'active' : '' }}">
                                    <p>1</p>
                                    <i
                                        class="awesome {{ $progressBarStatus['step1_active'] ?? false ? 'fa-solid fa-check' : 'hidden' }}"></i>
                                </div>
                                <p class="label">Diproses Admin</p>
                            </li>
                            <li>
                                <i class="icons fa-solid fa-building-circle-arrow-right"></i>
                                <div class="step second {{ $progressBarStatus['step2_active'] ?? false ? 'active' : '' }}">
                                    <p>2</p>
                                    <i
                                        class="awesome {{ $progressBarStatus['step2_active'] ?? false ? 'fa-solid fa-check' : 'hidden' }}"></i>
                                </div>
                                <p class="label">Diproses Perusahaan</p>
                            </li>
                            <li>
                                <i class="icons fa-solid fa-file-circle-check"></i>
                                <div class="step third {{ $progressBarStatus['step3_active'] ?? false ? 'active' : '' }}">
                                    <p>3</p>
                                    <i class="awesome fa-solid {{ $progressBarStatus['step3_icon'] ?? 'fa-check' }}"></i>
                                </div>
                                <p class="label">Lamaran Disetujui</p>
                            </li>
                            <li>
                                <i class="icons fa-solid fa-person-walking-arrow-right"></i>
                                <div class="step fourth {{ $progressBarStatus['step4_active'] ?? false ? 'active' : '' }}">
                                    <p>4</p>
                                    <i
                                        class="awesome {{ $progressBarStatus['step4_active'] ?? false ? 'fa-solid fa-check' : 'hidden' }}"></i>
                                </div>
                                <p class="label">Magang Berlangsung</p>
                            </li>
                            <li>
                                <i class="icons fa-solid fa-thumbs-up"></i>
                                <div class="step fifth {{ $progressBarStatus['step5_active'] ?? false ? 'active' : '' }}">
                                    <p>5</p>
                                    <i
                                        class="awesome {{ $progressBarStatus['step5_active'] ?? false ? 'fa-solid fa-check' : 'hidden' }}"></i>
                                </div>
                                <p class="label">Magang Selesai</p>
                            </li>
                        </ul>
                    </div>
                    <div class="row gy-4 gy-sm-1 border rounded mx-4" style="padding: 3vh;">
                        @if ($detailLamaranTerakhir)
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                    <div>
                                        <h5 class="mb-0">{{ $detailLamaranTerakhir['nama_perusahaan'] }}</h5>
                                        <p class="mb-0">Perusahaan</p>
                                    </div>
                                    <div class="avatar me-sm-4">
                                        <span class="avatar-initial rounded bg-label-secondary text-heading">
                                            <i class="bx bx-file bx-md"></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none me-4">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                    <div>
                                        <h5 class="mb-0">{{ $detailLamaranTerakhir['bidang_industri'] }}</h5>
                                        <p class="mb-0">Bidang Industri</p>
                                    </div>
                                    <div class="avatar me-lg-4">
                                        <span class="avatar-initial rounded bg-label-warning text-heading">
                                            <i class="bx bx-loader-circle bx-md"></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                    <div>
                                        <h5 class="mb-0">{{ $detailLamaranTerakhir['posisi_magang'] }}</h5>
                                        <p class="mb-0">Posisi Magang</p>
                                    </div>
                                    <div class="avatar me-sm-4">
                                        <span class="avatar-initial rounded bg-label-danger text-heading">
                                            <i class="bx bx-x-circle bx-md"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">{{ $detailLamaranTerakhir['tanggal_dikirim'] }}</h5>
                                        <p class="mb-0">Tanggal Dikirim</p>
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-success text-heading">
                                            <i class="bx bx-check-circle bx-md"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Tampilkan pesan jika tidak ada lamaran --}}
                            <div class="col-12 text-center">
                                <p>Anda belum memiliki lamaran terbaru.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card d-flex justify-content-start align-items-center mt-4" style="padding: 5vh">
        <div class="d-flex justify-content-between align-items-center mb-3 w-100">
            <h5 class="mb-0">Rekomendasi Lowongan Buat Kamu</h5>
            <a href="{{ url('rekomendasi') }}" class="btn text-primary">Tampilkan Perhitungan Rekomendasi</a>
        </div>
        <div class="col-lg-12 col-xl-12">
            <div class="row">
                @foreach ($rekomendasiTerurut as $index => $lowongan)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <span
                                    class="position-absolute top-0 end-0 badge bg-primary m-2">#{{ $index + 1 }}</span>
                                <div class="d-flex mb-3">
                                    <img src="{{ $lowongan->perusahaan->path_logo ?? 'https://via.placeholder.com/60' }}"
                                        alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $lowongan->nama_posisi }}</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>{{ $lowongan->perusahaan->nama_perusahaan }}
                                        </p>
                                        <p class="card-text text-muted small  mb-1">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $lowongan->perusahaan->alamat }}
                                        </p>
                                        <p class="card-text text-muted small  mb-1">
                                            <i class="bi bi-briefcase me-1"></i>Kuota: {{ $lowongan->kuota }} orang
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2 d-flex justify-content-between align-items-center">
                                    <p class="card-text small mb-0">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran
                                        {{ \Carbon\Carbon::parse($lowongan->tanggal_selesai)->locale('id')->isoFormat('D MMMM YYYY'), }}
                                    </p>
                                    <a href="{{ url('daftar-lowongan', $lowongan->id_lowongan) }}?dari_rekomendasi=1"
                                        class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
            <a href="{{ url('daftar-lowongan') }}" class="btn text-primary">Lihat Semua Lowongan</a>
    </div>
@endsection

@push('scripts')
    {{-- <script>
    $(document).ready(function () {
        $('#lamaranTable').DataTable({
            paging: false,
            language: {
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Tidak ada data ditampilkan"
            }
        });
    });
</script> --}}
@endpush
