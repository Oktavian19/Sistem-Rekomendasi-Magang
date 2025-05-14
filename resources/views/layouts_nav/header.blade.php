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
      <a href="#" class="btn btn-outline-primary" style="font-size: 1rem">Login</a>
  
    </div>
  </nav>