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
    html {
      scroll-behavior: smooth;
      scroll-padding-top: 80px; /* Adjust based on your header height */
    }
    
    /* If you need more specific control for certain sections */
    section[id] {
      scroll-margin-top: 80px; /* Same as header height */
    }
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
              <a class="nav-link text-dark" style="font-size: 1rem" href="#">Beranda</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#bidangKeahlian">Bidang Keahlian</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#lowonganTerbaru">Lowongan Terbaru</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="#ssd">SSD</a>
              <a class="nav-link text-dark" style="font-size: 1rem" href="https://docs.google.com/document/d/1JQtxjj5FWhHMQsAdGyISucFklJ2SZXIb/edit?usp=sharing&ouid=115429365200999512022&rtpof=true&sd=true">Manual Book</a>
            </div>

            <a href="{{ url('/login') }}" class="btn btn-outline-primary" style="font-size: 1rem">Login</a>
        
          </div>
        </nav>
        
        
        <!-- Hero Section -->
        <section style="height: 90vh; background-color: #27548A">
          <div class="container h-100">
            <div class="row h-100 ms-5 ps-5">
              <!-- Left Content - Tetap di tengah vertikal -->
              <div class="col-lg-4 text-white d-flex flex-column justify-content-center">
                <h1 class="fw-bold text-white mb-3" style="font-size: 2.5rem;">Temukan<br>Magang impianmu<br>Bersama Kami</h1>
              </div>

              <!-- Right Image - Rata bawah -->
              <div class="col-lg-8 d-flex align-items-end">
                <img src="{{ asset('sneat/assets/img/hero-img.png') }}" alt="Hero Image" class="img-fluid" style="max-height: 100%;">
              </div>
            </div>
          </div>
        </section>

        <div class="container" style="margin-top: 8vh; scroll-margin-top: 8vh; padding-left: 10vh; padding-right: 10vh" id="bidangKeahlian">
          <!-- Header Section -->
          <div class="row justify-content-between align-items-center mb-4">
              <div class="col-auto">
                  <h3 class="fw-bold">Bidang Keahlian</h3>
                  <p class="text-muted" style="font-size: 1.2rem">Temukan berbagai lowongan berdasarkan bidang keahlian</p>
              </div>
              <div class="col-auto">
                  <a href="{{ url('daftar-lowongan') }}" class="btn btn-outline-primary fs-6">
                      Lihat Semua <i class="fa fa-angle-right ms-1"></i>
                  </a>
              </div>
          </div>
  
          <!-- Job Field Cards -->
          <div class="row g-4 mt-5">
              @foreach($bidangKeahlian as $bidang)
              <div class="col-lg-4">
                  <a href="#" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('{{ $bidangGambar[$bidang->id] }}');"></div>
                          <div class="category-title">{{ $bidang->label }}</div>
                      </div>
                  </a>
              </div>
              @endforeach
              <div class="col-lg-4">
                  <a href="#" class="text-decoration-none text-dark">
                      <div class="border rounded p-3 category-card h-100 d-flex align-items-center">
                          <div class="pxp-cover me-3" style="background-image: url('sneat/assets/img/1.png');"></div>
                          <div class="category-title">Bidang Keahlian Lainnya</div>
                      </div>
                  </a>
              </div>
          </div>
        </div>
  </div>
  <div class="bg-light" style="width: 100vw; padding: 3vw; margin-top: 10vh;" id="lowonganTerbaru">
    <div class="container">
      <h4 class="fw-bold text-center">Lowongan Terbaru</h4>
    <p class="text-muted text-center fs-6">Tersedia 1001 lowongan dari berbagai perusahaan</p>
    <div class="row mt-2 mt-md-1 g-4">
        @foreach($lowongans as $lowongan)
            <div class="col-lg-4">
                <div class="card border h-100 shadow-sm">
                    <div class="card-body d-flex">
                        <img src="{{ $lowongan->perusahaan->path_logo ?? 'https://via.placeholder.com/60' }}" 
                             alt="Logo {{ $lowongan->perusahaan->nama_perusahaan }}" 
                             class="me-3 rounded" 
                             style="width: 60px; height: 60px; object-fit: cover;">

                        <div>
                            <h5 class="card-title mb-1">
                                <a href="#" 
                                   class="text-decoration-none text-dark">
                                    {{ $lowongan->nama_posisi }}
                                </a>
                            </h5>
                            <p class="mb-1 small text-muted">
                                <i class="bi bi-building"></i>
                                <a href="#" 
                                   class="text-decoration-none text-muted">
                                    {{ $lowongan->perusahaan->nama_perusahaan }}
                                </a>
                            </p>
                            <p class="mb-1 small text-muted">
                                <i class="bi bi-geo-alt"></i> {{ $lowongan->perusahaan->alamat }}
                            </p>
                            <p class="mb-0 small text-muted">
                                <i class="bi bi-briefcase"></i> Dibutuhkan {{ $lowongan->kuota }} orang
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>
                            Akhir Pendaftaran {{ \Carbon\Carbon::parse($lowongan->tanggal_tutup)->locale('id')->isoFormat('D MMMM YYYY') }}
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
  </div>
</div>

    <div class="text-center mt-5">
        <a href="{{ url('daftar-lowongan') }}" class="btn btn-outline-primary rounded-pill">Lihat Semua <i class="fa fa-angle-right"></i></a>
    </div>
    </div>
  
</div>

<div class="container" style="margin-top: 8vh; margin-bottom: 8vh; padding-top: 8vh; padding-bottom: 8vh; padding-left: 10vh; padding-right: 10vh; scroll-margin-top: 10vh;" id="ssd">
    <h4 class="text-center mb-1">
      Soal sering
      <span class="position-relative fw-extrabold z-1"
        >ditanya
      </span>
    </h4>
    <p class="text-center mb-12 pb-md-4">Telusuri SSD ini dan temukan jawaban atas pertanyaan yang sering ditanyakan.</p>
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
              <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">Apa tujuan utama dari Sistem Rekomendasi Magang ini?</button>
            </h2>

            <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">Tujuan utama sistem ini adalah membantu mahasiswa menemukan tempat magang yang paling sesuai dengan profil akademik, keterampilan, dan preferensi pribadi secara otomatis, sehingga mempercepat dan mempermudah proses pencarian magang baik bagi mahasiswa maupun perusahaan mitra, serta meningkatkan efisiensi dan kualitas pengalaman magang. </div>
            </div>
          </div>
          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">Bagaimana cara mahasiswa mendaftar dan membuat profil di sistem?</button>
            </h2>
            <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <ol type="A">
                        <li>Mahasiswa mengakses halaman registrasi dan melakukan pendaftaran dengan mengisi data dasar (NIM, nama, email, password).</li>
                        <li>Setelah akun aktif, mahasiswa login ke dalam sistem.</li>
                        <li>Mahasiswa melengkapi profil akademik dan keterampilan—termasuk bidang keahlian, sertifikasi, pengalaman, serta preferensi lokasi atau jenis magang—melalui menu “Kelola Profil”.</li>
                    </ol>
                </div>
            </div>
          </div>
          <div class="card accordion-item active">
            <h2 class="accordion-header" id="headingThree">
              <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">Metode rekomendasi apa yang dipakai untuk mencocokkan mahasiswa dengan perusahaan mitra?</button>
            </h2>
            <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                    Sistem menggunakan <b>algoritma rekomendasi berbasis data</b> yang secara otomatis mencocokkan parameter profil mahasiswa (kompetensi, keahlian, dan preferensi) dengan kebutuhan dan kriteria yang ditentukan oleh perusahaan mitra. Dengan demikian, setiap mahasiswa akan memperoleh daftar lowongan magang yang paling relevan dengan profilnya.
              </div>
            </div>
          </div>
          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">Dokumen apa saja yang harus diunggah mahasiswa saat mengajukan lamaran magang?</button>
            </h2>
            <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
              <div class="accordion-body">Saat melakukan pengajuan lamaran, mahasiswa harus mengunggah dokumen pendukung berikut:</div>
              <ul>
                <li>Curriculum Vitae (CV)</li>
                <li>Surat pengantar (cover letter)</li>
                <li>Sertifikat pendukung (jika ada)</li>
                <li>Dokumen lain yang diminta perusahaan (misalnya portofolio)</li>
              </ul>
            </div>
          </div>
          <div class="card accordion-item">
            <h2 class="accordion-header" id="headingFive">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">Bagaimana proses persetujuan atau penolakan pengajuan magang di sistem?</button>
            </h2>
            <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <ol type="A">
                    <li>Setelah mahasiswa mengajukan lamaran, Admin jurusan akan menerima notifikasi pengajuan tersebut di dashboard “Manajemen Kegiatan Magang”.</li>
                    <li>Admin meninjau detail lamaran dan dokumen yang diunggah.</li>
                    <li>Melalui sistem, Admin dapat memilih opsi “setuju” (approve) atau “tolak” (reject) untuk setiap pengajuan.</li>
                    <li>Sistem kemudian mengirimkan notifikasi otomatis kepada mahasiswa tentang status pengajuan (diterima/ditolak), dan mahasiswa bisa memantau status ini di halaman “Status Pengajuan Magang”. </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

    <footer id="footer" class="footer" style="padding: 7vh; background-color: #27548A">
        <div class="footer-top">
            <div class="container text-light">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-4 col-md-6 footer-info">
                        <a href="#" class="footer-logo d-flex align-items-center">
                            <span class="text-light">SIMAGANG</span>
                        </a>
                        <p class="mt-3">Sistem Manajemen Magang Digital Mahasiswa yang dirancang untuk pencatatan
                            dan pengelolaan magang mahasiswa secara terpusat.</p>
                        <div class="footer-contact mt-4">
                            <p><i class="bi bi-geo-alt-fill me-2"></i>Jl. Soekarno Hatta No.9, Jatimulyo, Kec.
                                Lowokwaru, Kota Malang, Jawa Timur 65141</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4 class="text-light">Hubungi Kami</h4>
                        <p class="mt-3">
                            <i class="bi bi-telephone-fill me-2"></i> +62 878-6192-6248<br>
                            <i class="bi bi-envelope-fill me-2"></i> info@simagang.ac.id<br>
                        </p>
                        <div class="social-links mt-4">
                            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container footer-bottom">
            <div class="copyright text-white">
                &copy; <span id="current-year">2024</span> <strong><span>SIMAGANG</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>

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

@stack('scripts')
<script>
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      
      const targetId = this.getAttribute('href');
      if(targetId === '#') return;
      
      const targetElement = document.querySelector(targetId);
      if(targetElement) {
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
        
        history.pushState(null, null, targetId);
      }
    });
  });
</script>

</body>
</html>
