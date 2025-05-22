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
                                <a href="#" class="text-dark text-decoration-none h2 fw-bold mb-1">
                                    {{ $mahasiswa->nama }}
                                </a>
                                <div class="d-flex flex-wrap align-items-center mt-2">
                                    <span class="text-muted me-3">
                                        <i class="bi bi-envelope me-1"></i>{{ $mahasiswa->email }}
                                    </span>
                                    <span class="text-muted me-3">
                                        <i class="bi bi-telephone me-1"></i>{{ $mahasiswa->no_hp ?? '-' }}
                                    </span>
                                    <span class="text-muted me-3">
                                        <i
                                            class="bi bi-mortarboard me-1"></i>{{ $mahasiswa->programStudi->nama_program_studi ?? '-' }}
                                    </span>
                                </div>

                            </div>
                            <a href="{{ url('/profile/edit') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                        </div>
                        <div class="d-flex gap-2 mt-4 mb-3 align-items-center">
                            <form id="formUploadCV" action="{{ url('profile/dokumen/store') }}" method="POST"
                                enctype="multipart/form-data" class="m-0 p-0">
                                @csrf
                                <input type="hidden" name="jenis_dokumen" value="Curriculum Vitae (CV)">
                                <input type="file" id="inputCV" name="path_file" accept=".pdf" class="d-none"
                                    onchange="document.getElementById('formUploadCV').submit()" required>
                        
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="document.getElementById('inputCV').click()">
                                    <i class="bi bi-upload me-1"></i> Upload CV
                                </button>
                            </form>
                        
                            <a href="{{ url('profile/dokumen/download-cv') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-download me-1"></i> Download CV
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
                @foreach ($mahasiswa->dokumen as $dokumen)
                    @if (!$dokumen->jenis_dokumen == 'CV')
                        <div class="border rounded p-4 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-text-fill text-primary fs-1 me-3"></i>
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $dokumen->jenis_dokumen }}</h5>
                                    <div class="d-flex flex-wrap text-muted">
                                        <span class="me-3">
                                            <i
                                                class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->translatedFormat('d M Y') }}
                                        </span>
                                        <a href="{{ asset('storage/' . $dokumen->path_file) }}"
                                            class="btn btn-sm btn-outline-primary ms-3" target="_blank">
                                            <i class="bi bi-download me-1"></i> Unduh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

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
                @foreach ($mahasiswa->pengalamanKerja as $pengalaman)
                    <div class="mb-4">
                        <h5 class="fw-bold">{{ $pengalaman->nama_posisi }}</h5>
                        <div class="d-flex align-items-center text-muted mb-2">
                            <span>{{ $pengalaman->nama_perusahaan }}</span>
                            <span>{{ \Carbon\Carbon::parse($pengalaman->tanggal_mulai)->translatedFormat('M Y') }} -
                                {{ \Carbon\Carbon::parse($pengalaman->tanggal_selesai)->translatedFormat('M Y') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
