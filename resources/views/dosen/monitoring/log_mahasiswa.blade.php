@extends('layouts.app')

@section('title', 'Log Magang | Sistem Rekomendasi Magang')

@section('content')

<section class="card">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between my-6">
            <h4 class="mb-0">Log Magang Andi Wijaya</h4>
          </div>
          
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="row">
                    <!-- Job Listing 1 -->
                    <div class="col-md-12 mb-4">
                        <div class="card border border-light h-100">
                            <div class="card-body position-relative">
                                <!-- Date Section -->
                                <div class="mb-3">
                                    <p class="fw-semibold mb-1">
                                        <i class="bi bi-calendar me-3"></i>01 Jun 2025
                                    </p>
                                    <p class="fw-semibold mb-0"></p>
                                </div>
                                
                                <!-- Description Section -->
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta libero eu dolor pellentesque auctor. Fusce volutpat rhoncus ante id elementum. Ut venenatis, turpis sed dapibus faucibus, velit mi convallis lectus, quis sagittis ipsum risus tincidunt neque. Phasellus erat elit, varius ac ex sed, pulvinar dictum arcu. Aliquam nisl lorem, condimentum quis nulla non, interdum mattis massa. Donec finibus, nisi in porta maximus, diam tortor venenatis nulla, sit amet viverra ligula quam vitae lacus. Curabitur maximus elit vitae ullamcorper ultricies. Donec facilisis bibendum erat nec finibus. Mauris molestie vehicula purus quis fermentum. Suspendisse sit amet turpis nibh. Mauris gravida ex id interdum egestas.
                        
                                        Praesent facilisis volutpat lorem sit amet suscipit. Duis malesuada, turpis ut placerat accumsan, sem augue egestas purus, eget fringilla ex orci tincidunt tellus. Quisque laoreet nunc et ligula vehicula fringilla. Ut ultricies cursus laoreet. Fusce scelerisque nisl in porttitor congue. Sed vel sapien non turpis consectetur tincidunt. Proin id tortor nec turpis eleifend fringilla. Nam porttitor felis nisl, quis tristique lorem ullamcorper vel. Donec feugiat ultricies elit, ac eleifend nibh lacinia sed. Pellentesque sit amet iaculis est. Integer tellus orci, faucibus vitae mi at, faucibus dignissim diam. Ut eget mi diam. Suspendisse potenti. Nunc sed sem sed massa posuere finibus eu quis eros. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="card border border-light h-100">
                            <div class="card-body position-relative">
                                <!-- Date Section -->
                                <div class="mb-3">
                                    <p class="fw-semibold mb-1">
                                        <i class="bi bi-calendar me-3"></i>02 Jun 2025
                                    </p>
                                    <p class="fw-semibold mb-0"></p>
                                </div>
                                
                                <!-- Description Section -->
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta libero eu dolor pellentesque auctor. Fusce volutpat rhoncus ante id elementum. Ut venenatis, turpis sed dapibus faucibus, velit mi convallis lectus, quis sagittis ipsum risus tincidunt neque. Phasellus erat elit, varius ac ex sed, pulvinar dictum arcu. Aliquam nisl lorem, condimentum quis nulla non, interdum mattis massa. Donec finibus, nisi in porta maximus, diam tortor venenatis nulla, sit amet viverra ligula quam vitae lacus. Curabitur maximus elit vitae ullamcorper ultricies. Donec facilisis bibendum erat nec finibus. Mauris molestie vehicula purus quis fermentum. Suspendisse sit amet turpis nibh. Mauris gravida ex id interdum egestas.
                        
                                        Praesent facilisis volutpat lorem sit amet suscipit. Duis malesuada, turpis ut placerat accumsan, sem augue egestas purus, eget fringilla ex orci tincidunt tellus. Quisque laoreet nunc et ligula vehicula fringilla. Ut ultricies cursus laoreet. Fusce scelerisque nisl in porttitor congue. Sed vel sapien non turpis consectetur tincidunt. Proin id tortor nec turpis eleifend fringilla. Nam porttitor felis nisl, quis tristique lorem ullamcorper vel. Donec feugiat ultricies elit, ac eleifend nibh lacinia sed. Pellentesque sit amet iaculis est. Integer tellus orci, faucibus vitae mi at, faucibus dignissim diam. Ut eget mi diam. Suspendisse potenti. Nunc sed sem sed massa posuere finibus eu quis eros. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">...</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">59</a></li>
                        <li class="page-item"><a class="page-link" href="#">60</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
     data-backdrop="static" data-keyboard="false" aria-hidden="true">
</div>

@push('scripts')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush