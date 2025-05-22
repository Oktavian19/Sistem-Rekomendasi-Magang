@extends('layouts.app')

@section('title', 'Histori | Sistem Rekomendasi Magang')

@section('content')
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

<div class="card d-flex justify-content-start align-items-start" style="padding: 5vh">
    <div class="d-flex justify-content-between align-items-center mb-3 w-100">
        <h4 class="mb-0">Riwayat Magang</h4>
    </div> 
    <div class="col-lg-12 col-xl-12">
        <div class="row">
            {{-- <div class="col-md-4 mb-4">
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
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="small text-warning mb-0 badge rounded-pill bg-label-warning" role="button" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                    <i class="bi bi-star me-1"></i> Beri Rating
                                </a>
                                
                                <p class="card-text small text-success mb-0 badge rounded-pill bg-label-success">
                                    <i class="bi bi-send-check me-1"></i>Diterima
                                </p>
                                
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
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
                                <p class="card-text small text-danger mb-0 badge rounded-pill bg-label-danger">
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
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex justify-content-end">
                                <p class="card-text small text-danger mb-0 badge rounded-pill bg-label-danger">
                                    <i class="bi bi-send-x me-1"></i>Ditolak
                                </p>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div> --}}
            @foreach($lamarans as $lamaran)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="{{ $lamaran->lowongan->perusahaan->logo_url ?? 'https://via.placeholder.com/60' }}" 
                                 alt="Company Logo" 
                                 class="rounded me-3" 
                                 width="60" 
                                 height="60">
                            <div>
                                <h5 class="card-title mb-1">{{ $lamaran->lowongan->nama_posisi }}</h5>
                                <p class="card-text text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i>{{ $lamaran->lowongan->perusahaan->nama_perusahaan }}
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $lamaran->lowongan->perusahaan->alamat }}
                                </p>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            @if($lamaran->status_lamaran == 'ditolak')
                                <div class="d-flex justify-content-end">
                                    <p class="card-text small text-danger mb-0 badge rounded-pill bg-label-danger">
                                        <i class="bi bi-send-x me-1"></i>Ditolak
                                    </p>
                                </div>
                            @elseif($lamaran->status_lamaran == 'menunggu')
                                <div class="d-flex justify-content-end">
                                    <p class="card-text small text-warning mb-0 badge rounded-pill bg-label-warning">
                                        <i class="bi bi-hourglass-split me-1"></i>Menunggu
                                    </p>
                                </div>
                            @elseif($lamaran->status_lamaran == 'diterima')
                                @if($lamaran->magang->status_magang == 'aktif')
                                    <div class="d-flex justify-content-end">
                                        <p class="card-text small text-success mb-0 badge rounded-pill bg-label-success">
                                            <i class="bi bi-send-check me-1"></i>Diterima
                                        </p>
                                    </div>
                                @elseif($lamaran->magang->status_magang == 'selesai')
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="#" class="small text-warning mb-0 badge rounded-pill bg-label-warning" role="button" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                            <i class="bi bi-star me-1"></i> Beri Rating
                                        </a>
                                        <p class="card-text small text-success mb-0 badge rounded-pill bg-label-success">
                                            <i class="bi bi-send-check me-1"></i>Diterima
                                        </p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    
</div>

<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Beri Rating Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm">
                    <div class="mb-3">
                        <label class="form-label">Perusahaan</label>
                        <input type="text" class="form-control" value="{{ $lamaran->lowongan->perusahaan->nama_perusahaan }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Posisi Magang</label>
                        <input type="text" class="form-control" value="{{ $lamaran->lowongan->nama_posisi }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durasi Magang</label>
                        <input type="text" class="form-control" value="{{ $lamaran->lowongan->durasi_magang }} bulan" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea class="form-control" rows="3" placeholder="Berikan komentar tentang pengalaman magang Anda"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating-input">
                            <i class="bi bi-star fs-3" data-value="1"></i>
                            <i class="bi bi-star fs-3" data-value="2"></i>
                            <i class="bi bi-star fs-3" data-value="3"></i>
                            <i class="bi bi-star fs-3" data-value="4"></i>
                            <i class="bi bi-star fs-3" data-value="5"></i>
                            <input type="hidden" name="rating" id="ratingValue">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submitRating">Kirim Rating</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
@endpush
