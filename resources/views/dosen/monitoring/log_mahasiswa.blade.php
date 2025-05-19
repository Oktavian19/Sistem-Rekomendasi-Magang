@extends('layouts.app')

@section('title', 'Log Magang | Sistem Rekomendasi Magang')

@section('content')

<section class="card">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between my-6">
            <h4 class="mb-0">Log Magang Andi Wijaya</h4>
        </div>
        <div class="row gy-4 gy-sm-1 border border-primary rounded mx-0 mb-3" style="padding: 3vh;">
            <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                    <div>
                        <h5 class="mb-0">PT. Tech Indonesia</h5>
                        <p class="mb-0">Perusahaan</p>
                    </div>
                    <div class="avatar me-sm-4">
                        <span class="avatar-initial rounded bg-label-secondary text-heading">
                            <i class="bx bx-file bx-md"></i>
                        </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none me-4">
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                    <div>
                        <h5 class="mb-0">Teknologi Informasi</h5>
                        <p class="mb-0">Bidang Industri</p>
                    </div>
                    <div class="avatar me-lg-4">
                        <span class="avatar-initial rounded bg-label-warning text-heading">
                            <i class="bx bx-loader-circle bx-md"></i>
                        </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none">
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                    <div>
                        <h5 class="mb-0">Fullstack Developer</h5>
                        <p class="mb-0">Posisi Magang</p>
                    </div>
                    <div class="avatar me-sm-4">
                        <span class="avatar-initial rounded bg-label-danger text-heading">
                            <i class="bx bx-x-circle bx-md"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">1 Januari 2023</h5>
                        <p class="mb-0">Tanggal Dikirim</p>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success text-heading">
                            <i class="bx bx-check-circle bx-md"></i>
                        </span>
                    </div>
                </div>
            </div>
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
                                        <i class="bi bi-calendar me-3"></i>Minggu ke-1
                                    </p>
                                </div>
                                
                                <!-- Image Gallery -->
                                <div class="mb-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <img src="https://cdn-brilio-net.akamaized.net/webp/photonews/2024/07/20/292638/750xauto-11-meme-lucu-pasrah-dengan-kehidupan-ini-relate-abis-bikin-angguk-setuju-2407206-001.jpg" class="img-thumbnail" style="max-height: 150px;">
                                        <img src="https://cdn-brilio-net.akamaized.net/webp/photonews/2024/07/20/292638/750xauto-11-meme-lucu-pasrah-dengan-kehidupan-ini-relate-abis-bikin-angguk-setuju-2407206-001.jpg" class="img-thumbnail" style="max-height: 150px;">
                                        <img src="https://cdn-brilio-net.akamaized.net/webp/photonews/2024/07/20/292638/750xauto-11-meme-lucu-pasrah-dengan-kehidupan-ini-relate-abis-bikin-angguk-setuju-2407206-001.jpg" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                </div>
                                
                                <!-- Description Section -->
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                         Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet volutpat mauris laoreet dictum. Praesent pharetra tellus ut justo posuere, quis feugiat urna pharetra. Etiam ut volutpat metus. In in quam posuere, sollicitudin lectus a, porttitor lectus. Praesent dignissim vulputate enim, sit amet congue eros commodo at. Integer lobortis molestie orci, a aliquam velit congue ac. Curabitur molestie eget tellus viverra molestie. Proin libero arcu, imperdiet sed neque quis, pellentesque suscipit leo. Donec pellentesque metus vitae orci tempus, id ultrices dolor congue. Proin imperdiet aliquam risus, et porttitor diam tincidunt sed.

Aliquam eleifend, ex ut blandit finibus, tellus ante malesuada metus, at aliquam odio lectus dignissim mauris. In non accumsan magna. Aenean tincidunt eros sed malesuada facilisis. Aliquam erat volutpat. Fusce bibendum massa eu pharetra maximus. Praesent mattis risus id diam viverra suscipit. Phasellus vestibulum ex ipsum, et molestie tortor aliquam id. Donec mi massa, interdum quis lacus ut, sollicitudin feugiat libero. Proin pretium eget ante eget accumsan. Vestibulum non tincidunt tellus, sit amet facilisis justo. Nullam mattis vestibulum neque id ullamcorper. In feugiat dolor sapien, a pretium mauris ultricies et. Duis a ornare dui. In placerat odio sit amet purus aliquet, hendrerit cursus justo pretium. Pellentesque iaculis egestas lacus. Maecenas sit amet iaculis odio. 
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
                                        <i class="bi bi-calendar me-3"></i>Minggu ke-2
                                    </p>
                                </div>
                                
                                <!-- Image Gallery -->
                                <div class="mb-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <img src="https://cdn-brilio-net.akamaized.net/webp/photonews/2024/07/20/292638/750xauto-11-meme-lucu-pasrah-dengan-kehidupan-ini-relate-abis-bikin-angguk-setuju-2407206-001.jpg" class="img-thumbnail" style="max-height: 150px;">
                                        <img src="https://cdn-brilio-net.akamaized.net/webp/photonews/2024/07/20/292638/750xauto-11-meme-lucu-pasrah-dengan-kehidupan-ini-relate-abis-bikin-angguk-setuju-2407206-001.jpg" class="img-thumbnail" style="max-height: 150px;">
                                        <img src="https://cdn-brilio-net.akamaized.net/webp/photonews/2024/07/20/292638/750xauto-11-meme-lucu-pasrah-dengan-kehidupan-ini-relate-abis-bikin-angguk-setuju-2407206-001.jpg" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                </div>
                                
                                <!-- Description Section -->
                                <div class="border-top pt-2">
                                    <p class="card-text small">
                                         Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet volutpat mauris laoreet dictum. Praesent pharetra tellus ut justo posuere, quis feugiat urna pharetra. Etiam ut volutpat metus. In in quam posuere, sollicitudin lectus a, porttitor lectus. Praesent dignissim vulputate enim, sit amet congue eros commodo at. Integer lobortis molestie orci, a aliquam velit congue ac. Curabitur molestie eget tellus viverra molestie. Proin libero arcu, imperdiet sed neque quis, pellentesque suscipit leo. Donec pellentesque metus vitae orci tempus, id ultrices dolor congue. Proin imperdiet aliquam risus, et porttitor diam tincidunt sed.

Aliquam eleifend, ex ut blandit finibus, tellus ante malesuada metus, at aliquam odio lectus dignissim mauris. In non accumsan magna. Aenean tincidunt eros sed malesuada facilisis. Aliquam erat volutpat. Fusce bibendum massa eu pharetra maximus. Praesent mattis risus id diam viverra suscipit. Phasellus vestibulum ex ipsum, et molestie tortor aliquam id. Donec mi massa, interdum quis lacus ut, sollicitudin feugiat libero. Proin pretium eget ante eget accumsan. Vestibulum non tincidunt tellus, sit amet facilisis justo. Nullam mattis vestibulum neque id ullamcorper. In feugiat dolor sapien, a pretium mauris ultricies et. Duis a ornare dui. In placerat odio sit amet purus aliquet, hendrerit cursus justo pretium. Pellentesque iaculis egestas lacus. Maecenas sit amet iaculis odio. 
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