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

  <!-- Menu Utama (Scrollable) -->
  <ul class="menu-inner py-1" style="height: calc(100% - 70px); overflow-y: auto;">
    <!-- Dashboard (Visible to all roles) -->
    <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
      <a href="#" class="menu-link">
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
        <li class="menu-item {{ request()->is('periode*') ? 'active' : '' }}">
          <a href="{{ url('periode') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar"></i>
            <div>Periode Magang</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('user*') ? 'active' : '' }}">
          <a href="{{ url('user') }}" class="menu-link">
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
      @endif

      @if(auth()->user()->role === 'mahasiswa')
        <!-- Mahasiswa Menu Items -->
        <li class="menu-item {{ request()->is('daftar-lowongan*') ? 'active' : '' }}">
          <a href="{{ url('lowongan-magang') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-briefcase"></i>
            <div>Lowongan Magang</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('magang-mahasiswa*') ? 'active' : '' }}">
          <a href="{{ url('magang-mahasiswa') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-clipboard"></i>
            <div>Log Magang</div>
          </a>
        </li>
      @endif

      @if(auth()->user()->role === 'dosen_pembimbing')
        <!-- Dosen Menu Items -->
        <li class="menu-item {{ request()->is('dosen*') ? 'active' : '' }}">
          <a href="{{ url('dosen/list-mahasiswa') }}" class="menu-link">
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
        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</aside>