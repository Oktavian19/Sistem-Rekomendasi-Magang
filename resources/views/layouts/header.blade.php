<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="navbar-nav align-items-center">
    <div class="nav-item d-flex align-items-center">
      <a href="javascript:void(0);" class="nav-link layout-menu-toggle d-xl-none">
        <i class="bx bx-menu text-primary" style="font-size: 35px;"></i>
      </a>
    </div>
  </div>

  <div class="d-flex align-items-center ms-auto">
    @php
      $user = Auth::user();
      $name = match ($user->role) {
          'mahasiswa' => $user->mahasiswa->nama ?? $user->username,
          'dosen_pembimbing' => $user->dosenPembimbing->nama ?? $user->username,
          'admin' => $user->admin->nama ?? $user->username,
          default => $user->username,
      };
    @endphp

    <span class="me-3">{{ $name }}</span>

    <div class="dropdown">
      <a href="#" class="d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        @if (!empty($user->photo_url))
            <img src="{{ $user->photo_url }}" class="rounded-circle" style="width: 40px; height: 40px;" alt="User">
        @else
            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white"
                style="width: 40px; height: 40px;">
                <i class="bi bi-person" style="font-size: 20px;"></i>
            </div>
        @endif
        <i class="bx bx-chevron-down ms-1"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="{{ url('/profile') }}">Profil</a></li>
        <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>