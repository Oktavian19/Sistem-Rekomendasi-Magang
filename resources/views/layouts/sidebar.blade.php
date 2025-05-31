<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="#" class="app-brand-link d-flex align-items-center">
      <span class="app-brand-logo demo">
        <img src="{{ asset('sneat/assets/img/logo.png') }}" alt="Logo Perusahaan" style="width: 40px">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">SIMAGANG</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
      <i class="bx bx-chevron-left"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1" style="height: calc(100% - 70px); overflow-y: auto;">
    <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
      <a href="{{ 
          auth()->user()->role === 'mahasiswa' ? url('dashboard-mahasiswa') : 
          (auth()->user()->role === 'dosen_pembimbing' ? url('dashboard-dosen') : 
          (auth()->user()->role === 'admin' ? url('dashboard-admin') : url('dashboard'))) 
        }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home"></i>
        <div>Dashboard</div>
      </a>
    </li>
    

    @auth
      @if(auth()->user()->role === 'admin')
        <!-- Admin Menu Items -->
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
        {{-- <li class="menu-item {{ request()->is('periode*') ? 'active' : '' }}">
          <a href="{{ url('periode') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar"></i>
            <div>Periode Magang</div>
          </a>
        </li> --}}
        <li class="menu-item {{ request()->is('input*') ? 'active open' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-edit"></i>
            <div class="text-truncate">Kelola Input</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ request()->is('input-fasilitas*') ? 'active' : '' }}">
              <a href="{{ url('input-fasilitas') }}" class="menu-link">
                <div class="text-truncate" data-i18n="Fasilitas">Input Fasilitas</div>
              </a>
            </li>
          </ul>
          <ul class="menu-sub">
            <li class="menu-item {{ request()->is('input-bidang-keahlian*') ? 'active' : '' }}">
              <a href="{{ url('input-bidang-keahlian') }}" class="menu-link">
                <div class="text-truncate" data-i18n="Bidang Keahlian">Input Bidang Keahlian</div>
              </a>
            </li>
          </ul>
        </li>
        {{-- <li class="menu-item {{ request()->is('lowongan*') ? 'active' : '' }}">
          <a href="{{ url('lowongan') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-folder-open"></i>
            <div>Manajemen Magang</div>
          </a>
        </li> --}}
        <li class="menu-item {{ request()->is(['periode*', 'lowongan*', 'lamaran*']) ? 'active open' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-folder-open"></i>
            <div class="text-truncate" data-i18n="ManajemenMagang">Manajemen Magang</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ request()->is('periode*') ? 'active' : '' }}">
              <a href="{{ url('periode') }}" class="menu-link">
                <div class="text-truncate" data-i18n="Periode">Periode Magang</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('lowongan*') ? 'active' : '' }}">
              <a href="{{ url('lowongan') }}" class="menu-link">
                <div class="text-truncate" data-i18n="Lowongan">Lowongan Magang</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('lamaran*') ? 'active' : '' }}">
              <a href="{{ url('lamaran') }}" class="menu-link">
                <div class="text-truncate" data-i18n="Lamaran">Lamaran Magang</div>
              </a>
            </li>
          </ul>
        </li>
      @endif

      @if(auth()->user()->role === 'mahasiswa')
        <!-- Mahasiswa Menu Items -->
        <li class="menu-item {{ request()->is('daftar-lowongan*') ? 'active' : '' }}">
          <a href="{{ url('daftar-lowongan') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-briefcase"></i>
            <div>Lowongan Magang</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('log-kegiatan*') ? 'active' : '' }}">
          <a href="{{ url('log-kegiatan') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-clipboard"></i>
            <div>Log Magang</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('riwayat-magang*') ? 'active' : '' }}">
          <a href="{{ url('riwayat-magang') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-history"></i>
            <div>Riwayat Magang</div>
          </a>
        </li>
      @endif

      @if(auth()->user()->role === 'dosen_pembimbing')
        <!-- Dosen Menu Items -->
        <li class="menu-item {{ request()->is('monitoring*') ? 'active' : '' }}">
          <a href="{{ url('monitoring') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
            <div>Monitoring & Statistik</div>
          </a>
        </li>
      @endif
    @endauth
  </ul>

  <!-- Menu Logout (Fixed di Bawah) -->
  <div class="fixed-bottom-menu" style="position: sticky; bottom: 0; background-color: inherit; border-top: 1px solid rgba(0,0,0,0.1);">
    <ul class="menu-inner">
      <li class="menu-item">
        <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="menu-icon tf-icons bx bx-log-out"></i>
          <div>Logout</div>
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="GET" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</aside>