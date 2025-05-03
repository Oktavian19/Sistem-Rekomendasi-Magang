<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <li class="nav-item">
          <span class="fw-semibold">Hi, {{ Auth::user()->nama ?? 'Guest' }}</span>
        </li>
      </ul>
    </div>
  </nav>
  