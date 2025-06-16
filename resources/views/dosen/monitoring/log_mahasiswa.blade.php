@extends('layouts.app')

@section('title', 'Log Magang Mahasiswa | Sistem Rekomendasi Magang')

@section('content')

    <section class="card">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between my-6">
                <h4 class="mb-0">Log Magang {{ $mahasiswa->nama ?? 'Mahasiswa' }}</h4>
                <a href="{{ url('/monitoring') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>

            @if ($magang)
                <div class="row gy-4 gy-sm-1 border border-primary rounded mx-0 mb-3" style="padding: 3vh;">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center border-end pb-4 pb-sm-0">
                            <div>
                                <h5 class="mb-0">{{ $magang->lamaran->lowongan->perusahaan->nama_perusahaan }}</h5>
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
                                <h5 class="mb-0">{{ $magang->lamaran->lowongan->perusahaan->bidang_industri }}</h5>
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
                                <h5 class="mb-0">{{ $magang->lamaran->lowongan->nama_posisi }}</h5>
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
                                <h5 class="mb-0">{{ $magang->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</h5>
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
                            @forelse($logs as $log)
                                <!-- Log Entry -->
                                <div class="col-md-12 mb-4">
                                    <div class="card border border-light h-100">
                                        <div class="card-body position-relative">
                                            <!-- Date Section -->
                                            <div class="mb-3">
                                                <p class="fw-semibold mb-1">
                                                    <i class="bi bi-calendar me-3"></i>
                                                    Minggu ke-{{ $loop->iteration }} ({{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }})
                                                </p>
                                            </div>

                                            <!-- Image Gallery -->
                                            <div class="mb-3">
                                                <div class="d-flex flex-wrap gap-2">
                                                    @if ($log->dokumen && $log->dokumen->count() > 0)
                                                        @foreach ($log->dokumen as $dokumen)
                                                            <img src="{{ asset($dokumen->path_file) }}"
                                                                class="img-thumbnail"
                                                                style="max-height: 150px; cursor: pointer;"
                                                                onclick="showImageModal('{{ asset($dokumen->path_file) }}')">
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted">Tidak ada dokumen/lampiran</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Description Section -->
                                            <div class="border-top pt-2">
                                                <p class="card-text small">
                                                    {{ $log->deskripsi_kegiatan }}
                                                </p>
                                            </div>

                                            <!-- Tombol Feedback -->
                                            <div class="mt-3">
                                                <button class="btn btn-sm btn-primary btn-feedback"
                                                    data-modal-action="{{ url('logs/' . $log->id_log . '/feedback-form') }}">
                                                    <i class="bi bi-chat-left-text"></i> Beri Feedback
                                                </button>
                                            </div>

                                             <!-- Feedback Section -->
                                            @if($log->feedback->count() > 0)
                                                <div class="mt-3 pt-3 border-top">
                                                    <h6 class="fw-semibold">Feedback Dosen:</h6>
                                                    @foreach($log->feedback as $feedback)
                                                        <div class="card mb-2 bg-primary text-white">
                                                            <div class="card-body p-3">
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <span class="fw-semibold">
                                                                        {{ $feedback->user->dosenPembimbing->nama ?? 'Dosen' }}
                                                                    </span>
                                                                </div>
                                                                <p class="mb-0">{{ $feedback->komentar }}</p>
                                                                <small class="text-muted">
                                                                    {{ \Carbon\Carbon::parse($feedback->tanggal_feedback)->locale('id')->isoFormat('D MMMM YYYY') }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        Mahasiswa belum mencatat log kegiatan magang.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if ($logs->hasPages())
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center mt-4">
                                    @if ($logs->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1"
                                                aria-disabled="true">Previous</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $logs->previousPageUrl() }}">Previous</a>
                                        </li>
                                    @endif

                                    @foreach (range(1, $logs->lastPage()) as $i)
                                        <li class="page-item {{ $logs->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $logs->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endforeach

                                    @if ($logs->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $logs->nextPageUrl() }}">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    Mahasiswa belum memiliki data magang.
                </div>
            @endif
        </div>
    </section>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dokumen Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Dokumen Kegiatan">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle feedback button clicks
            $(document).on('click', '.btn-feedback', function() {
                var url = $(this).data('modal-action');
                $('#myModal .modal-dialog').load(url, function(response, status, xhr) {
                    if (status === "error") {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Gagal Memuat',
                            text: 'Terjadi kesalahan saat memuat konten.',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                        return;
                    }
                    $('#myModal').modal('show');
                });
            });

            // Image modal function
            function showImageModal(imageUrl) {
                const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                document.getElementById('modalImage').src = imageUrl;
                modal.show();
            }
        });
    </script>
@endpush
