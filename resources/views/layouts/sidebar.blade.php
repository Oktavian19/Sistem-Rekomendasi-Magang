<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="#" class="app-brand-link d-flex align-items-center">
        <span class="app-brand-logo demo">
            <img src="{{ asset('sneat/assets/img/logo.png') }}" alt="Logo Perusahaan" style="width: 40px">
        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">SIMAGANG</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left d-block d-xl-none"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    <!-- Dashboard -->
    <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <li class="menu-item {{ request()->is('perusahaan*') ? 'active' : '' }}">
      <a href="{{ url('perusahaan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-building"></i>
        <div>Perusahaan Mitra</div>
      </a>
    </li>
    <li class="menu-item {{ request()->is('program-studi*') ? 'active' : '' }}">
      <a href="{{ url('program-studi') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div>Program Studi</div>
      </a>
    </li>
    <li class="menu-item {{ request()->is('periode*') ? 'active' : '' }}">
      <a href="{{ url('periode') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div>Periode Magang</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-plus"></i>
        <div>Manajemen Akun</div>
      </a>
    </li>
    <li class="menu-item {{ request()->is('lowongan*') ? 'active' : '' }}">
      <a href="{{ url('lowongan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-folder-open"></i>
        <div>Manajemen Magang</div>
      </a>
    </li>

    <!-- Proses Pengajuan -->
    <li class="menu-item {{ request()->is('daftar-lowongan*') ? 'active' : '' }}">
      <a href="{{ url('lowongan-magang') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-briefcase"></i>
        <div>Lowongan Magang</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-send"></i>
        <div>Proses Pengajuan</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="#" class="menu-link">Ajukan Magang</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Status Pengajuan</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Persetujuan Lamaran</a></li>
      </ul>
    </li>

    <!-- Profil Mahasiswa -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Profil Mahasiswa</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="#" class="menu-link">Profil & Preferensi</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Unggah Dokumen</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Cari Lowongan</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Rekomendasi Magang</a></li>
      </ul>
    </li>

    <!-- Pembimbingan -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-chalkboard"></i>
        <div>Pembimbingan</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="#" class="menu-link">Plot Dosen Pembimbing</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Mahasiswa Bimbingan</a></li>
        <li class="menu-item"><a href="#" class="menu-link">Log Kegiatan</a></li>
      </ul>
    </li>

    <!-- Monitoring -->
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bar-chart"></i>
        <div>Monitoring & Statistik</div>
      </a>
    </li>

    

    <!-- Logout -->
    <li class="menu-item">
      <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div>Logout</div>
      </a>
      <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>

  </ul>
</aside>
