@extends('layouts.app')

@section('title', 'Dashboard | Sistem Rekomendasi Magang')

@section('content')
@push('styles')
<style>
    .card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
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
                    <ul>
                        <li>
                            <i class="icons fa-solid fa-user"></i>
                            <div class="step first active">
                                <p>1</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Profile</p>
                        </li>
                        <li>
                            <i class="icons fa-solid fa-coins"></i>
                            <div class="step second">
                                <p>2</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Finances</p>
                        </li>
                        <li>
                            <i class="icons fa-solid fa-house"></i>
                            <div class="step third">
                                <p>3</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Property</p>
                        </li>
                        <li>
                            <i class="icons fa-regular fa-star-half-stroke"></i>
                            <div class="step fourth">
                                <p>4</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Evaluation</p>
                        </li>
                        <li>
                            <i class="icons fa-solid fa-thumbs-up"></i>
                            <div class="step fifth">
                                <p>5</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Approval</p>
                        </li>
                    </ul>
                </div>
                <div class="row gy-4 gy-sm-1 border rounded mx-4" style="padding: 3vh;">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                            <div>
                                <h5 class="mb-0">PT. Tech Indonesia</h5>
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
                                <h5 class="mb-0">Teknologi Informasi</h5>
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
                                <h5 class="mb-0">Fullstack Developer</h5>
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
                                <h5 class="mb-0">1 Januari 2023</h5>
                                <p class="mb-0">Tanggal Dikirim</p>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success text-heading">
                                    <i class="bx bx-check-circle bx-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>


<div class="card d-flex justify-content-start align-items-start mt-4" style="padding: 5vh">
    <div class="d-flex justify-content-between align-items-center mb-3 w-100">
        <h5 class="mb-0">Rekomendasi Lowongan Buat Kamu</h5>
        <a href="{{ url('daftar-lowongan') }}" class="btn text-primary">Lihat Semua Lowongan</a>
    </div> 
    <div class="col-lg-12 col-xl-12">
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Software Engineer</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>PT Teknologi Hebat
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Jakarta
                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: 5 orang
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <p class="card-text small">
                                <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 30 Jun 2025
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Card 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Digital Marketing</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>CV Media Kreatif
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Bandung
                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: 3 orang
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <p class="card-text small">
                                <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 15 Jul 2025
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Digital Marketing</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>CV Media Kreatif
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Bandung
                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: 3 orang
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <p class="card-text small">
                                <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 15 Jul 2025
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Digital Marketing</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>CV Media Kreatif
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Bandung
                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: 3 orang
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <p class="card-text small">
                                <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 15 Jul 2025
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Digital Marketing</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>CV Media Kreatif
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Bandung
                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: 3 orang
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <p class="card-text small">
                                <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 15 Jul 2025
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Digital Marketing</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>CV Media Kreatif
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Bandung
                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: 3 orang
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <p class="card-text small">
                                <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 15 Jul 2025
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add more cards as needed -->
        </div>
    </div>
    
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
