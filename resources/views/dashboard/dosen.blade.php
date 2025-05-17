@extends('layouts.app')

@section('content')
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">30</h4>
                                    <p class="mb-0">Jumlah Lamaran<br> Diproses</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-danger text-heading">
                                        <i class="bx bx-x-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">120</h4>
                                    <p class="mb-0">Jumlah Mahasiswa<br> Magang</p>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">45</h4>
                                    <p class="mb-0">Jumlah Mahasiswa <br>Selesai Magang</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success text-heading">
                                        <i class="bx bx-check-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">45 : 120</h4>
                                    <p class="mb-0">Rasio Dosen :<br> Mahasiswa Magang</p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-warning text-heading">
                                        <i class="bx bx-loader-circle bx-md"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <div class="bg-white p-4 rounded">
        <div class="row mt-4">
            <div class="col-md-5">
            <div class="box shadow">
                <div id="bar"></div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="box shadow">
                <div id="donutTop"></div>
            </div>
            </div>
            <div class="col-md-3">
            <div class="box shadow">
                <div id="radialBar1"></div>
            </div>
            </div>
        </div>

        {{-- Tren perusahaan 4 rating tertinggi dan total siswa magangnya --}}
        <div class="row mt-4 mb-5">
            <div class="col-md-6">
            <div class="row sparkboxes mt-4">
                <div class="col-md-6">
                <div class="box box1">
                    <div id="spark1"></div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="box box2">
                    <div id="spark2"></div>
                </div>
                </div>
            </div>
            <div class="row sparkboxes mt-3">
                <div class="col-md-6">
                <div class="box box3">
                    <div id="spark3"></div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="box box4">
                    <div id="spark4"></div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="box body-bg">
                <div
                id="area-adwords"
                style="background: #fff"
                class="shadow"
                ></div>
            </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{ asset('sneat/assets/js/chart.js') }}"></script>
@endpush
