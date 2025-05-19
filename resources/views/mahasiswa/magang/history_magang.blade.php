@extends('layouts.app')

@section('title', 'Histori | Sistem Rekomendasi Magang')

@section('content')

<div class="card d-flex justify-content-start align-items-start" style="padding: 5vh">
    <div class="d-flex justify-content-between align-items-center mb-3 w-100">
        <h4 class="mb-0">Histori Magang</h4>
    </div> 
    <div class="col-lg-12 col-xl-12">
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Software Engineer</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>PT Teknologi Hebat
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Jakarta
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex justify-content-end">
                                <p class="card-text small text-danger mb-0">
                                    <i class="bi bi-send-x me-1"></i>Ditolak
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
    
            <!-- Card 2 -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/60" alt="Company Logo" class="rounded me-3" width="60" height="60">
                            <div>
                                <h5 class="card-title mb-1">Digital Marketing</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>CV Media Kreatif
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>Bandung
                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: 3 orang
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex justify-content-end">
                                <p class="card-text small text-danger mb-0">
                                    <i class="bi bi-send-x me-1"></i>Ditolak
                                </p>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <!-- Add more cards as needed -->
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
{{-- <script>
    $(document).ready(function () {
        $('#lamaranTable').DataTable({
            paging: false,
            language: {
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Tidak ada data ditampilkan"
            }
        });
    });
</script> --}}

@endpush
