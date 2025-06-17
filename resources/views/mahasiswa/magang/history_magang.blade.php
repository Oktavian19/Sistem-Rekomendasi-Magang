@extends('layouts.app')

@section('title', 'Histori | Sistem Rekomendasi Magang')

@push('styles')
    <style>
        .rating-input i {
            cursor: pointer;
            color: #ddd;
            transition: color 0.2s;
        }

        .rating-input i.active {
            color: #ffc107;
        }
    </style>
@endpush

@section('content')
    <section class="card">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between my-6">
                <h4 class="mb-0">Riwayat Magang</h4>
            </div>

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        @forelse ($lamarans as $lamaran)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $lamaran->lowongan->perusahaan->logo_url }}" alt="Company Logo"
                                                    class="rounded me-3" width="60" height="60"
                                                    onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none');">

                                                <div class="d-none rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bi bi-building fs-3 text-muted"></i>
                                                </div>
                                            </div>

                                            <div>
                                                <h5 class="card-title mb-1">{{ $lamaran->lowongan->nama_posisi }}</h5>
                                                <p class="card-text text-muted small mb-1">
                                                    <i
                                                        class="bi bi-building me-1"></i>{{ $lamaran->lowongan->perusahaan->nama_perusahaan }}
                                                </p>
                                                <p class="card-text text-muted small">
                                                    <i
                                                        class="bi bi-geo-alt me-1"></i>{{ $lamaran->lowongan->perusahaan->alamat }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="border-top pt-2">
                                            @if (isset($lamaran))
                                                @if ($lamaran->status_lamaran == 'ditolak')
                                                    <div class="d-flex justify-content-end">
                                                        <p
                                                            class="card-text small text-danger mb-0 badge rounded-pill bg-label-danger">
                                                            <i class="bi bi-send-x me-1"></i>Ditolak
                                                        </p>
                                                    </div>
                                                @elseif($lamaran->status_lamaran == 'diprosesAdmin')
                                                    <div class="d-flex justify-content-end">
                                                        <p
                                                            class="card-text small text-warning mb-0 badge rounded-pill bg-label-warning">
                                                            <i class="bi bi-hourglass-split me-1"></i>Diproses Admin
                                                        </p>
                                                    </div>
                                                @elseif($lamaran->status_lamaran == 'diprosesPerusahaan')
                                                    <div class="d-flex justify-content-end">
                                                        <p
                                                            class="card-text small text-warning mb-0 badge rounded-pill bg-label-warning">
                                                            <i class="bi bi-hourglass-split me-1"></i>Diproses Perusahaan
                                                        </p>
                                                    </div>
                                                @elseif($lamaran->status_lamaran == 'diterima')
                                                    @if (!isset($lamaran->magang))
                                                        <div class="d-flex justify-content-end">
                                                            <p
                                                                class="card-text small text-info mb-0 badge rounded-pill bg-label-info">
                                                                <i class="bi bi-check-circle me-1"></i>Diterima (Belum
                                                                Magang)
                                                            </p>
                                                        </div>
                                                    @elseif($lamaran->magang->status_magang == 'aktif')
                                                        <div class="d-flex justify-content-end">
                                                            <p
                                                                class="card-text small text-success mb-0 badge rounded-pill bg-label-success">
                                                                <i class="bi bi-send-check me-1"></i>Diterima
                                                            </p>
                                                        </div>
                                                    @elseif($lamaran->magang->status_magang == 'selesai')
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            @if($lamaran->magang->feedback->isEmpty())
                                                            <a href="javascript:void(0);"
                                                                onclick="modalAction('{{ url('feedback/modal/' . ($lamaran->magang->id_magang ?? 0)) }}')"
                                                                class="small text-warning mb-0 badge rounded-pill bg-label-warning">
                                                                <i class="bi bi-star me-1"></i> Beri Feedback
                                                            </a>
                                                            @endif
                                                            <p
                                                                class="card-text small text-success mb-0 badge rounded-pill bg-label-success">
                                                                <i class="bi bi-send-check me-1"></i>Diterima
                                                            </p>
                                                        </div>
                                                    @endif
                                                @endif
                                            @else
                                                {{-- Condition for belum melamar/null --}}
                                                <div class="d-flex justify-content-end">
                                                    <p
                                                        class="card-text small text-secondary mb-0 badge rounded-pill bg-label-secondary">
                                                        <i class="bi bi-dash-circle me-1"></i>Belum Melamar
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="alert alert-info">Belum ada riwayat magang.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-input i');
            const ratingValue = document.getElementById('ratingValue');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    ratingValue.value = value;

                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.add('active');
                            s.classList.remove('bi-star');
                            s.classList.add('bi-star-fill');
                        } else {
                            s.classList.remove('active');
                            s.classList.remove('bi-star-fill');
                            s.classList.add('bi-star');
                        }
                    });
                });

                star.addEventListener('mouseover', function() {
                    const value = parseInt(this.getAttribute('data-value'));

                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.add('bi-star-fill');
                        } else {
                            s.classList.remove('bi-star-fill');
                            s.classList.add('bi-star');
                        }
                    });
                });

                star.addEventListener('mouseout', function() {
                    const currentRating = parseInt(ratingValue.value) || 0;

                    stars.forEach((s, index) => {
                        if (index < currentRating) {
                            s.classList.add('bi-star-fill');
                        } else {
                            s.classList.remove('bi-star-fill');
                            s.classList.add('bi-star');
                        }
                    });
                });
            });

            document.getElementById('submitRating').addEventListener('click', function() {
                const rating = ratingValue.value;
                const comment = document.querySelector('#ratingForm textarea').value;

                if (!rating) {
                    alert('Silakan beri rating terlebih dahulu');
                    return;
                }

                // Here you would typically send the data to your server
                alert(`Rating ${rating} bintang dan komentar telah dikirim!`);

                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                modal.hide();
            });
        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endpush
