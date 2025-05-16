@extends('layouts.app')

@section('title', 'Profil | Sistem Rekomendasi Magang')

@section('content')
<div class="col-lg-12">
    <!-- Profile Header -->
    <div class="card mb-3">
        <div class="card-body pt-4">
            <div class="d-flex justify-content-between">
                <div class="me-4 mb-4">
                    <div class="position-relative">
                        <img src="https://bucket.sdmdigital.id/dts-simonas/photo/a7c4e502-414b-4b2b-b130-ecdcb9a31a83.jpg" 
                             class="rounded-circle" width="120" height="120" alt="Profile Image">
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <a href="#" class="text-dark text-decoration-none h2 fw-bold mb-1">VIRA ALFITA YUNIA</a>
                            <div class="d-flex flex-wrap align-items-center mt-2">
                                <span class="text-muted me-3">
                                    <i class="bi bi-envelope me-1"></i>viraalfita1813@gmail.com
                                </span>
                                <span class="text-muted me-3">
                                    <i class="bi bi-telephone me-1"></i>(+62) 812-3456-7890
                                </span>
                                <span class="text-muted me-3">
                                    <i class="bi bi-mortarboard me-1"></i>D-IV Teknik Informatika
                                </span>
                            </div>
                        </div>
                        <a href="{{ url('/profile/edit') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    </div>
                    <div class="d-flex mt-4 mb-3">
                        <a href="https://diploy.id/user/profile/edit" class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-upload me-1"></i>Upload CV
                        </a>
                        <a href="https://diploy.id/user/profile/export" class="btn btn-sm btn-primary">
                            <i class="bi bi-download me-1"></i>Download CV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificates -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">
                Dokumen Pendukung
            </h4>
        </div>
        <div class="card-body">
            <div class="border rounded p-4 mb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-file-earmark-text-fill text-primary fs-1 me-3"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Bootcamp Fullstack Developer Udemy</h5>
                        <div class="d-flex flex-wrap text-muted">
                            <span class="me-3">
                                <i class="bi bi-credit-card-2-front me-1"></i>Sertifikat
                            </span>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="border rounded p-4 mb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-file-earmark-text-fill text-primary fs-1 me-3"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Surat Pengantar Magang</h5>
                        <div class="d-flex flex-wrap text-muted">
                            <span class="me-3">
                                <i class="bi bi-envelope-paper me-1"></i>Surat Pengantar
                            </span>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>

    <!-- Work Experience -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">
                Pengalaman Kerja
            </h4>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5 class="fw-bold">Freelance Developer</h5>
                <div class="d-flex align-items-center text-muted mb-2">
                    <span>Nexteam Teknologi Indonesia</span>
                    <span class="mx-2">•</span>
                    <span>2023 - Saat ini (1 tahun 6 bulan)</span>
                </div>
            </div>
            <div class="mb-4">
                <h5 class="fw-bold">Bussiness Process Engineer</h5>
                <div class="d-flex align-items-center text-muted">
                    <span>PT RetGoo Sentris Informa</span>
                    <span class="mx-2">•</span>
                    <span>Jan 2022 - Dec 2022 (0 tahun 11 bulan)</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection