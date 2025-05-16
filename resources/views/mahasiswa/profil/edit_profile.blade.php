@section('title', 'Edit Profile | Sistem Rekomendasi Magang')

@extends('layouts.app')

@section('content')
<div class="card mb-5 border">
    <div class="card-header">
        <div class="card-title">
            <h4 class="fw-bold"><i class="bi bi-person text-dark fs-3 me-2"></i>Informasi Pribadi</h4>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="https://diploy.id/user/profile/edit" enctype="multipart/form-data">
            <div class="row">
                <!-- Personal Information -->
                <div class="col-lg-6 mb-4">
                    <div class="form-group">
                        <label class="required form-label">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="nama" placeholder="Masukkan Nama Lengkap" value="VIRA ALFITA YUNIA" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="form-group">
                        <label class="required form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email" placeholder="Masukkan Email" value="viraalfita1813@gmail.com" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="form-group">
                        <label class="required form-label">No Telepon</label>
                        <input type="text" class="form-control form-control-sm" name="no_hp" placeholder="Masukkan No Telepon" value="08123456789" autocomplete="off">
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="form-group">
                        <label class="required form-label">Program Studi</label>
                        <select name="program_studi" class="form-control form-control-sm">
                            <option value="">Pilih Program Studi</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Teknik Komputer">Teknik Komputer</option>
                            <option value="Manajemen Informatika">Manajemen Informatika</option>
                        </select>
                    </div>
                </div>                
                
                <div class="col-lg-12 mb-4">
                    <div class="form-group">
                        <label class="required form-label">Keterampilan</label>
                        <select class="form-select form-select-sm select2" name="skills[]" data-control="select2" data-allow-clear="true" multiple="multiple" data-placeholder="Pilih Kemampuan">
                            <option value=""></option>
                            <option value="1">.NET</option>
                            <option value="2">A++</option>
                            <option value="3">Abacus System</option>
                            <option value="4">ABAP</option>
                            <option value="577">Penetration Testing</option>
                            <option value="6">ACAD</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-12 mb-4">
                    <div class="form-group">
                        <label class="required form-label">Alamat</label>
                        <textarea class="form-control form-control-sm" name="address" placeholder="Masukkan Alamat" autocomplete="off">Jl. Hamid Rusdi Gg 2B</textarea>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="col-lg-12 mt-4 text-center">
                    <a href="https://diploy.id/user/profile" class="btn btn-light-dark me-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="fa fa-paper-plane me-2"></i>Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-5 border">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="card-title">
                <h4 class="fw-bold m-0">
                    <i class="bi bi-briefcase text-dark fs-3 me-2"></i>Pengalaman
                </h4>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="modalAction('{{ url('create-pengalaman') }}')">
                    <i class="fa fa-plus me-2"></i>Tambah Pengalaman
                </button>
            </div>
        </div>
    </div>

    <!-- Experience List -->
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <!-- Experience Item 1 -->
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded">
                    <div>
                        <h5 class="fw-semibold mb-1">Freelance Developer</h5>
                        <div class="d-flex align-items-center text-muted small">
                            <span>Nexteam Teknologi Indonesia</span>
                            <span class="bullet bg-gray-400 mx-2"></span>
                            <span>2023 - Saat ini (1 tahun 18 bulan)</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-icon btn-light-primary btn-sm me-2 btnEdit" 
                                data-bs-toggle="modal" data-bs-target="#editExperienceModal"
                                data-action="https://diploy.id/user/experience/22845/edit"
                                data-company-name="Nexteam Teknologi Indonesia"
                                data-position="Freelance Developer"
                                data-start-date="10/2023"
                                data-still-here="1">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-icon btn-light-danger btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#modalDelete" 
                                onclick="openModalDelete()">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Experience Item 2 -->
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded">
                    <div>
                        <h5 class="fw-semibold mb-1">Bussiness Process Engineer</h5>
                        <div class="d-flex align-items-center text-muted small">
                            <span>PT RetGoo Sentris Informa</span>
                            <span class="bullet bg-gray-400 mx-2"></span>
                            <span>Jan 2022 - Dec 2022 (0 tahun 11 bulan)</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-icon btn-light-primary btn-sm me-2 btnEdit" 
                                data-bs-toggle="modal" data-bs-target="#editExperienceModal"
                                data-action="https://diploy.id/user/experience/22844/edit"
                                data-company-name="PT RetGoo Sentris Informa"
                                data-position="Bussiness Process Engineer"
                                data-start-date="01/2022"
                                data-end-date="12/2022"
                                data-still-here="2">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-icon btn-light-danger btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#modalDelete" 
                                onclick="openModalDelete()">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-5 border">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="card-title">
                <h4 class="fw-bold m-0">
                    <i class="bi bi-file-earmark-text text-dark fs-3 me-2"></i>Dokumen Pendukung
                </h4>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="modalAction('{{ url('mahasiswa/profil/form_dokumen') }}')">
                    <i class="fa fa-plus me-2"></i>Tambah Dokumen
                </button>
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <!-- Example Document Item 1 -->
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded">
                    <div>
                        <h5 class="fw-semibold mb-1">Curriculum Vitae (CV)</h5>
                        <div class="d-flex align-items-center text-muted small">
                            <span>Diunggah: 15 Jan 2023</span>
                            <span class="bullet bg-gray-400 mx-2"></span>
                            <span>PDF (2.4 MB)</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-icon btn-light-primary btn-sm me-2 btnEditDocument" 
                                data-bs-toggle="modal" data-bs-target="#editDocumentModal"
                                data-action="/dokumen/1"
                                data-jenis-dokumen="CV"
                                data-file-url="/storage/documents/cv.pdf">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-icon btn-light-danger btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#modalDelete" 
                                onclick="openModalDelete('/dokumen/1')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Example Document Item 2 -->
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded">
                    <div>
                        <h5 class="fw-semibold mb-1">Ijazah</h5>
                        <div class="d-flex align-items-center text-muted small">
                            <span>Diunggah: 10 Feb 2023</span>
                            <span class="bullet bg-gray-400 mx-2"></span>
                            <span>PDF (1.8 MB)</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-icon btn-light-primary btn-sm me-2 btnEditDocument" 
                                data-bs-toggle="modal" data-bs-target="#editDocumentModal"
                                data-action="/dokumen/2"
                                data-jenis-dokumen="Ijazah"
                                data-file-url="/storage/documents/ijazah.pdf">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-icon btn-light-danger btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#modalDelete" 
                                onclick="openModalDelete('/dokumen/2')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
     data-backdrop="static" data-keyboard="false" aria-hidden="true">
     <div class="modal-dialog modal-lg">
        <!-- Modal content will be loaded here -->
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
        });
    });

    function modalAction(url = '') {
        // Get the modal element
        const modalEl = document.getElementById('myModal');
        const modalDialog = modalEl.querySelector('.modal-dialog');
        
        // Clear previous content
        modalDialog.innerHTML = '';
        
        // Fetch and load new content
        fetch(url)
            .then(response => response.text())
            .then(html => {
                // Insert the content
                modalDialog.innerHTML = html;
                
                // Initialize Bootstrap modal
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            })
            .catch(error => {
                console.error('Error loading modal content:', error);
            });
    }
</script>
@endpush