@extends('layouts.app')

@section('title', 'Lowongan | Sistem Rekomendasi Magang')

@section('content')
<section class="">
    <div class="container">
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-auto">
                <h3 class="fw-bold">Lowongan Pekerjaan</h3>
                <span class="text-muted">Tersedia</span> 954 <span class="text-muted">Lowongan</span>
            </div>
            <div class="col-auto">
                <select class="form-select">
                    <option value="newest">Urutkan Terbaru</option>
                    <option value="oldest">Urutkan Terlama</option>
                    <option value="name_asc">Urutkan A - Z</option>
                    <option value="name_desc">Urutkan Z - A</option>
                </select>
            </div>
        </div>
    </div>
</section>

<section class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xl-3 mb-4">
                <div class="card mb-4 py-5">
                    <div class="card-header d-flex d-lg-none">
                        <div class="fw-bold">Filter</div>
                        <button class="btn btn-sm ms-auto"><i class="bi bi-sliders"></i></button>
                    </div>
                    <div class="card-body">
                        <form>
                            <span class="text-black">Kata Kunci</span>
                            <div class="mb-5 mt-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" name="keyword" placeholder="Cari">
                                </div>
                            </div>
                        
                            <span class="mt-4 text-black">Lokasi</span>
                            <div class="mb-5 mt-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <select class="form-select" name="province_id">
                                        <option value="">Semua</option>
                                        <option value="1">Aceh</option>
                                        <option value="2">Sumatera Utara</option>
                                        <!-- Other provinces -->
                                    </select>
                                </div>
                            </div>
                        
                            <span class="mt-4 text-black">Bidang Pekerjaan</span>
                            <div class="mb-5 mt-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-folder"></i></span>
                                    <select class="form-select" name="job_field_id">
                                        <option value="">Semua</option>
                                        <option value="52">Accounting</option>
                                        <option value="37">Administrasi</option>
                                        <!-- Other job fields -->
                                    </select>
                                </div>
                            </div>
                        
                            <span class="mt-5 text-black">Tingkat Pengalaman</span>
                            <div class="list-group mt-2">
                                <label class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="job_level_id[]" value="2" checked>
                                        Entry Level
                                    </span>
                                </label>
                                <label class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="job_level_id[]" value="1" checked>
                                        Intermediate Level
                                    </span>
                                </label>
                                <label class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="job_level_id[]" value="1" checked>
                                        Senior Level
                                    </span>
                                </label>
                                <!-- Other experience levels -->
                            </div>
                        
                            <button type="submit" class="btn btn-primary w-100 mt-4">Filter</button>
                        </form>                        
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8 col-xl-9">
                <div class="row">
                    <!-- Job Listing 1 -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">ERP Functional Consultant</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 01 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Job Listing 2 -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">Network Engineer</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 27 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">Network Engineer</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 27 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">Network Engineer</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 27 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">Network Engineer</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 27 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">Network Engineer</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 27 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">Network Engineer</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 27 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" 
                                         alt="Company Logo" class="rounded me-3" width="60" height="60">
                                    <div>
                                        <h5 class="card-title mb-1">Network Engineer</h5>
                                        <p class="card-text text-muted small mb-1">
                                            <i class="bi bi-building me-1"></i>PT. Berca Hardayaperkasa
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Jakarta Pusat
                                            <i class="bi bi-briefcase ms-2 me-1"></i>Intermediate Level
                                        </p>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        <i class="bi bi-clock me-1"></i>Akhir Pendaftaran 27 Jun 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- More job listings... -->
                </div>
                
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">...</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">59</a></li>
                        <li class="page-item"><a class="page-link" href="#">60</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection