<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('sneat/assets') }}/" data-template="vertical-menu-template-free">
<head>
  <style>
    @media (max-width: 1199.98px) {
      .layout-menu {
        transform: translateX(-100%);
        position: fixed;
        z-index: 1031;
        transition: transform 0.3s ease;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
      }
      
      .layout-menu-expanded .layout-menu {
        transform: translateX(0);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      }
      
      .layout-menu-expanded .layout-page {
        margin-left: 260px;
      }
      
      .layout-page {
        transition: margin-left 0.3s ease;
        width: 100%;
      }
    }
  </style>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/apex-charts/apex-charts.css') }}">

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Jquery UI-->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <!-- Helpers -->
  <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('sneat/assets/js/config.js') }}"></script>

  @stack('styles')
</head>
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      {{-- Sidebar --}}
      @include('layouts.sidebar')

      <!-- Layout container -->
      <div class="layout-page">

        {{-- Header --}}
        @include('layouts.header')

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Main content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
          </div>

          {{-- Footer --}}
          @include('layouts.footer')
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

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<!-- Jquery UI-->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

@stack('scripts')
<script>
  $(document).ready(function() {
    $('.layout-menu-toggle').on('click', function(e) {
      e.preventDefault();
      $('body').toggleClass('layout-menu-expanded');
    });

    $(document).on('click', function(e) {
      if ($(window).width() < 1200) {
        if (!$(e.target).closest('#layout-menu, .layout-menu-toggle').length && $('body').hasClass('layout-menu-expanded')) {
          $('body').removeClass('layout-menu-expanded');
        }
      }
    });

    $(window).on('resize', function() {
      if ($(window).width() >= 1200) {
        $('body').removeClass('layout-menu-expanded');
      }
    });
  });
</script>
</body>
</html>
