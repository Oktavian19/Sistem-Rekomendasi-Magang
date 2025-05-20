<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="container-fluid">
    <div class="d-flex align-items-center ms-auto">
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://media.licdn.com/dms/image/v2/D5603AQHFT5u3iioKTg/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1693154870303?e=1752710400&v=beta&t=tSIRg6BQEtRzKpZwixc0HTH-fRzM6kwbn-Ev_Mh3Ef8" class="rounded-circle" style="width: 40px; height: 40px;" alt="User">
          <i class="bx bx-chevron-down ms-1"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="{{ url('/profile') }}">Profil</a></li>
          <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>
