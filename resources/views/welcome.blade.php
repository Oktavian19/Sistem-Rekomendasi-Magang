<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('sneat/assets') }}/" data-template="vertical-menu-template-free">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>@yield('title')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Iconify / Boxicons / Icon CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/iconify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/apex-charts/apex-charts.css') }}">

  <!-- Helpers -->
  <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('sneat/assets/js/config.js') }}"></script>

  @stack('styles')
  <style>
    .category-card {
        transition: transform 0.2s;
    }
    .category-card:hover {
        transform: translateY(-5px);
    }
    .pxp-cover {
        width: 60px;
        height: 80px;
        background-size: cover;
        background-position: center;
        border-radius: 0.5rem;
    }
    .category-title {
        font-weight: 600;
        font-size: 1rem;
        margin-top: 0.5rem;
    }
</style>
</head>
<body class="bg-white">
  <!-- Layout wrapper -->
  <div class="layout-content-navbar">
        {{-- Header --}}
        <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm p-5">
          <div class="container d-flex justify-content-between align-items-center">
            
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
              <img src="{{ asset('sneat/assets/img/logo.png') }}" alt="Logo" style="height: 30px;" class="me-2">
              <span class="fw-bold mb-0" style="font-size: 1.5rem">SIMAGANG</span>
            </a>            
        
            <!-- Menu -->
            <div class="d-none d-lg-flex gap-9">
              <a class="nav-link text-dark" style="font-size: 1rem" href="#">Home</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#">Lowongan</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#">Virtual Internship</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#">Mentor Class</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#">Perusahaan</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#">Tentang</a>
            </div>
        
            <!-- Profile -->
            {{-- <div class="dropdown">
              <a href="#" class="d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="path/to/user.jpg" class="rounded-circle" style="width: 40px; height: 40px;" alt="User">
                <i class="bx bx-chevron-down ms-1"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="#">Profil</a></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
              </ul>
            </div> --}}
            <a href="{{ url('/login') }}" class="btn btn-outline-primary" style="font-size: 1rem">Login</a>
        
          </div>
        </nav>
        
        
        <!-- Hero Section -->
        <section class="bg-primary" style="height: 60vh;">
          <div class="container h-100">
            <div class="row h-100 ms-5 ps-5">
              <!-- Left Content - Tetap di tengah vertikal -->
              <div class="col-lg-5 text-white d-flex flex-column justify-content-center">
                <h1 class="fw-bold text-white mb-3" style="font-size: 2.5rem;">Temukan<br>Pekerjaan impianmu<br>dan Talenta terbaik</h1>
              </div>

              <!-- Right Image - Rata bawah -->
              <div class="col-lg-7 d-flex align-items-end">
                <img src="{{ asset('sneat/assets/img/hero-img.png') }}" alt="Hero Image" class="img-fluid" style="max-height: 90%;">
              </div>
            </div>
          </div>
        </section>

        <div class="container" style="margin-top: 8vh; padding-left: 10vh; padding-right: 10vh">
          <!-- Header Section -->
          <div class="row justify-content-between align-items-center mb-4">
              <div class="col-auto">
                  <h3 class="fw-bold">Bidang Pekerjaan</h3>
                  <p class="text-muted" style="font-size: 1.2rem">Temukan berbagai lowongan berdasarkan bidang pekerjaan</p>
              </div>
              <div class="col-auto">
                  <a href="https://diploy.id/kategori-list" class="btn btn-outline-primary fs-6">
                      Lihat Semua <i class="fa fa-angle-right ms-1"></i>
                  </a>
              </div>
          </div>
  
          <!-- Job Field Cards -->
          <div class="row g-4 mt-5">
              <!-- Card Item -->
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=2" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2Fd3d019d1-8bbe-47ff-b8c8-9ead895744c1.png');"></div>
                          <div class="category-title">Programming & Software Development</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=16" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2Fdd44f13e-51df-4d33-9f2f-b389e9d91cd4.png');"></div>
                          <div class="category-title">IT Consultancy & Advisory</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=4" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2F6531cc18-faa3-457e-b18a-5458b410da80.png');"></div>
                          <div class="category-title">Network & Infrastructure</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=1" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2F2ddedfde-5022-4d8d-97ce-030d4a163abf.png');"></div>
                          <div class="category-title">Data Management System</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=10" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2Fd2e0eae8-0a6b-4e63-b3a4-dfcb607e38db.png');"></div>
                          <div class="category-title">IT Security & Compliance</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=58" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('images/icon/1.png');"></div>
                          <div class="category-title">Other</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=42" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2F4b0813f1-167c-41c6-bbd0-59f1ad735f8d.png');"></div>
                          <div class="category-title">Sales</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=37" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2F64f29e9a-269c-4ac4-a4c0-941c3c507ae7.png');"></div>
                          <div class="category-title">Administrasi</div>
                      </div>
                  </a>
              </div>
  
              <div class="col-lg-4">
                  <a href="https://diploy.id/jobs?job_field_id=6" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('https://diploy.id/get-file?path=job-field%2Fddaa98d8-5bfe-42c3-bd5a-f90f79704288.png');"></div>
                          <div class="category-title">Information System & Technology Development</div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
  </div>
  <div class="bg-light" style="width: 100vw; padding: 3vw; margin-top: 10vh">
    <div class="container">
      <h4 class="fw-bold text-center">Lowongan Terbaru</h4>
    <p class="text-muted text-center fs-6">Tersedia 1001 lowongan dari berbagai perusahaan</p>

    <div class="row mt-4 mt-md-5 g-4">
        <!-- Card Start -->
        <div class="col-lg-4">
            <div class="card border h-100 shadow-sm">
                <div class="card-body d-flex">
                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    <div>
                        <h5 class="card-title mb-1">
                            <a href="https://diploy.id/jobs/1172" class="text-decoration-none text-dark">ERP Functional Consultant</a>
                        </h5>
                        <p class="mb-1 small text-muted">
                            <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                        </p>
                        <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                        <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 01 Jun 2025</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border h-100 shadow-sm">
                <div class="card-body d-flex">
                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    <div>
                        <h5 class="card-title mb-1">
                            <a href="https://diploy.id/jobs/1171" class="text-decoration-none text-dark">Network Engineer</a>
                        </h5>
                        <p class="mb-1 small text-muted">
                            <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                        </p>
                        <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                        <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 27 Jun 2025</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border h-100 shadow-sm">
                <div class="card-body d-flex">
                    <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    <div>
                        <h5 class="card-title mb-1">
                            <a href="https://diploy.id/jobs/1171" class="text-decoration-none text-dark">Network Engineer</a>
                        </h5>
                        <p class="mb-1 small text-muted">
                            <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                        </p>
                        <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                        <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 27 Jun 2025</small>
                </div>
            </div>
        </div>

        <!-- Tambahkan lagi card sesuai kebutuhan -->
    </div>
    <div class="row mt-2 mt-md-1 g-4">
      <!-- Card Start -->
      <div class="col-lg-4">
          <div class="card border h-100 shadow-sm">
              <div class="card-body d-flex">
                  <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                  <div>
                      <h5 class="card-title mb-1">
                          <a href="https://diploy.id/jobs/1172" class="text-decoration-none text-dark">ERP Functional Consultant</a>
                      </h5>
                      <p class="mb-1 small text-muted">
                          <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                      </p>
                      <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                      <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                  </div>
              </div>
              <div class="card-footer bg-white border-top-0">
                  <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 01 Jun 2025</small>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="card border h-100 shadow-sm">
              <div class="card-body d-flex">
                  <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                  <div>
                      <h5 class="card-title mb-1">
                          <a href="https://diploy.id/jobs/1171" class="text-decoration-none text-dark">Network Engineer</a>
                      </h5>
                      <p class="mb-1 small text-muted">
                          <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                      </p>
                      <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                      <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                  </div>
              </div>
              <div class="card-footer bg-white border-top-0">
                  <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 27 Jun 2025</small>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="card border h-100 shadow-sm">
              <div class="card-body d-flex">
                  <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                  <div>
                      <h5 class="card-title mb-1">
                          <a href="https://diploy.id/jobs/1171" class="text-decoration-none text-dark">Network Engineer</a>
                      </h5>
                      <p class="mb-1 small text-muted">
                          <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                      </p>
                      <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                      <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                  </div>
              </div>
              <div class="card-footer bg-white border-top-0">
                  <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 27 Jun 2025</small>
              </div>
          </div>
      </div>

      <!-- Tambahkan lagi card sesuai kebutuhan -->
  </div>
  <div class="row mt-2 mt-md-1 g-4">
    <!-- Card Start -->
    <div class="col-lg-4">
        <div class="card border h-100 shadow-sm">
            <div class="card-body d-flex">
                <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                <div>
                    <h5 class="card-title mb-1">
                        <a href="https://diploy.id/jobs/1172" class="text-decoration-none text-dark">ERP Functional Consultant</a>
                    </h5>
                    <p class="mb-1 small text-muted">
                        <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                    </p>
                    <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                    <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0">
                <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 01 Jun 2025</small>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border h-100 shadow-sm">
            <div class="card-body d-flex">
                <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                <div>
                    <h5 class="card-title mb-1">
                        <a href="https://diploy.id/jobs/1171" class="text-decoration-none text-dark">Network Engineer</a>
                    </h5>
                    <p class="mb-1 small text-muted">
                        <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                    </p>
                    <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                    <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0">
                <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 27 Jun 2025</small>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border h-100 shadow-sm">
            <div class="card-body d-flex">
                <img src="https://bucket.sdmdigital.id/dts-simonas/perusahaan-logo/38ae1aab-0348-43ef-bae6-a55a7aa8c1dd.jpeg" alt="Logo" class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                <div>
                    <h5 class="card-title mb-1">
                        <a href="https://diploy.id/jobs/1171" class="text-decoration-none text-dark">Network Engineer</a>
                    </h5>
                    <p class="mb-1 small text-muted">
                        <i class="bi bi-building"></i> <a href="https://diploy.id/companies/192" class="text-decoration-none text-muted">PT. Berca Hardayaperkasa</a>
                    </p>
                    <p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> Jakarta Pusat</p>
                    <p class="mb-0 small text-muted"><i class="bi bi-briefcase"></i> Karyawan Kontrak</p>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0">
                <small class="text-muted"><i class="bi bi-clock me-1"></i> Akhir Pendaftaran 27 Jun 2025</small>
            </div>
        </div>
    </div>

    <!-- Tambahkan lagi card sesuai kebutuhan -->
</div>

    <div class="text-center mt-5">
        <a href="https://diploy.id/jobs" class="btn btn-outline-primary rounded-pill">Lihat Semua <i class="fa fa-angle-right"></i></a>
    </div>
    </div>
  
</div>
<div class="container" style="margin-top: 8vh; padding-left: 10vh; padding-right: 10vh">
  <h4 class="fw-bold">Eksplor Fitur Lebih Lanjut</h4>
  <div class="row mt-4 mt-md-5">
      <!-- Kartu Talenta -->
      <div class="col-lg-4 mb-5">
          <div class="card h-100 border rounded-3 shadow-sm p-3">
              <div class="d-flex align-items-start">
                  <div class="me-3" style="width: 80px; height: 80px; background-size: cover; background-image: url('images/vector/talent-page.png'); border-radius: 8px;"></div>
                  <div>
                      <h6 class="fw-bold mb-2">Talenta</h6>
                      <p class="text-muted mb-3">Hi Digiers, ayo eksplor berbagai peluang menarik untuk perluasan kesempatan kerja melalui Diploy</p>
                      <a href="https://diploy.id/tentang-talenta" class="btn btn-sm btn-outline-primary rounded-pill">Lebih Lanjut</a>
                  </div>
              </div>
          </div>
      </div>
      <!-- Kartu Perusahaan -->
      <div class="col-lg-4 mb-5">
          <div class="card h-100 border rounded-3 shadow-sm p-3">
              <div class="d-flex align-items-start">
                  <div class="me-3" style="width: 80px; height: 80px; background-size: cover; background-image: url('images/ipad-building.png'); border-radius: 8px;"></div>
                  <div>
                      <h6 class="fw-bold mb-2">Perusahaan</h6>
                      <p class="text-muted mb-3">Mulai temukan dan rekrut talenta terbaik dari Lulusan dan Alumni program Digital Talent Scholarship, sekarang.</p>
                      <a href="https://diploy.id/tentang-perusahaan" class="btn btn-sm btn-outline-primary rounded-pill">Lebih Lanjut</a>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-4 mb-5">
        <div class="card h-100 border rounded-3 shadow-sm p-3">
            <div class="d-flex align-items-start">
                <div class="me-3" style="width: 80px; height: 80px; background-size: cover; background-image: url('images/ipad-building.png'); border-radius: 8px;"></div>
                <div>
                    <h6 class="fw-bold mb-2">Perusahaan</h6>
                    <p class="text-muted mb-3">Mulai temukan dan rekrut talenta terbaik dari Lulusan dan Alumni program Digital Talent Scholarship, sekarang.</p>
                    <a href="https://diploy.id/tentang-perusahaan" class="btn btn-sm btn-outline-primary rounded-pill">Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<div class="container" style="background-color: #DAD2FF; margin-top: 8vh; padding-top: 8vh; padding-left: 10vh; padding-right: 10vh">
    <h4 class="text-center mb-1">
      Frequently asked
      <span class="position-relative fw-extrabold z-1"
        >questions
      </span>
    </h4>
    <p class="text-center mb-12 pb-md-4">Browse through these FAQs to find answers to commonly asked questions.</p>
    <div class="row gy-12 align-items-center">
      <div class="col-lg-5">
        <div class="text-center">
          <img src="{{ asset('sneat/assets/img/faq.png') }}" alt="faq boy with logos" class="faq-image" style="max-width: 100%; height: auto;" />
        </div>
      </div>
      <div class="col-lg-7">
        <div class="accordion" id="accordionExample">
          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">Do you charge for each upgrade?</button>
            </h2>

            <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">Lemon drops chocolate cake gummies carrot cake chupa chups muffin topping. Sesame snaps icing marzipan gummi bears macaroon dragée danish caramels powder. Bear claw dragée pastry topping soufflé. Wafer gummi bears marshmallow pastry pie.</div>
            </div>
          </div>
          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">Do I need to purchase a license for each website?</button>
            </h2>
            <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans candy canes carrot cake. Fruitcake chocolate chupa chups.</div>
            </div>
          </div>
          <div class="card accordion-item active">
            <h2 class="accordion-header" id="headingThree">
              <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">What is regular license?</button>
            </h2>
            <div id="accordionThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Regular license can be used for end products that do not charge users for access or service(access is free and there will be no monthly subscription fee). Single regular license can be used for single end product and end product can be used by you or your client. If you want to sell end product to multiple clients then you will need to purchase separate license for each client. The same rule applies if you want to use the same end product on multiple domains(unique setup).
                For more info on regular license you can check official description.
              </div>
            </div>
          </div>
          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">What is extended license?</button>
            </h2>
            <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
              <div class="accordion-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis et aliquid quaerat possimus maxime! Mollitia reprehenderit neque repellat deleniti delectus architecto dolorum maxime, blanditiis earum ea, incidunt quam possimus cumque.</div>
            </div>
          </div>
          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingFive">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">Which license is applicable for SASS application?</button>
            </h2>
            <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
              <div class="accordion-body">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi molestias exercitationem ab cum nemo facere voluptates veritatis quia, eveniet veniam at et repudiandae mollitia ipsam quasi labore enim architecto non!</div>
            </div>
          </div>
        </div>
      </div>
    </div>



<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load DataTables.js -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Load Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Core JS -->
<script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>

<!-- Vendors JS -->
<script src="{{ asset('sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('sneat/assets/js/main.js') }}"></script>

<!-- Page JS (optional) -->
<script src="{{ asset('sneat/assets/js/dashboards-analytics.js') }}"></script>

<!-- Github Widget (optional) -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Optional: Your custom page-specific scripts -->
@stack('scripts')

</body>
</html>
