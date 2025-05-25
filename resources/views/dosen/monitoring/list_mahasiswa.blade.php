@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Mahasiswa</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="table-mahasiswa" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Beri Rating Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm">
                    <input type="hidden" id="studentId">
                    <div class="mb-3">
                        <label class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="studentName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" id="studentNim" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <input type="text" class="form-control" value="Teknik Informatika" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea class="form-control" id="studentComment" rows="3" placeholder="Berikan komentar tentang mahasiswa ini"></textarea>
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

@push('scripts')
<script>
    $(document).ready(function () {
        $('#table-mahasiswa').DataTable({
            processing: true,
            serverSide: false,
            data: [
                {
                    "DT_RowIndex": 1,
                    "nim": "210101001",
                    "nama": "Andi Wijaya",
                    "email": "andi@example.com",
                    "no_hp": "081234567890"
                },
                {
                    "DT_RowIndex": 2,
                    "nim": "210101002",
                    "nama": "Budi Santoso",
                    "email": "budi@example.com",
                    "no_hp": "082345678901",
                },
                {
                    "DT_RowIndex": 3,
                    "nim": "210101003",
                    "nama": "Citra Lestari",
                    "email": "citra@example.com",
                    "no_hp": "083456789012",
                },
                {
                    "DT_RowIndex": 4,
                    "nim": "210101004",
                    "nama": "Dewi Anggraeni",
                    "email": "dewi@example.com",
                    "no_hp": "084567890123",
                },
                {
                    "DT_RowIndex": 5,
                    "nim": "210101005",
                    "nama": "Eko Prasetyo",
                    "email": "eko@example.com",
                    "no_hp": "085678901234",
                }
            ],
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    className: 'text-center', 
                    orderable: true, 
                    searchable: true 
                },
                { 
                    data: 'nama', 
                    name: 'nama',
                    render: function(data, type, row) {
                        return `<a href="{{ url('dosen/log-mahasiswa') }}" class="text-primary">${data}</a>`;
                    }
                },
                { 
                    data: 'nim', 
                    name: 'nim' 
                },
                { 
                    data: 'email', 
                    name: 'email' 
                },
                { 
                    data: 'no_hp', 
                    name: 'no_hp' 
                },
                {
                    data: null,
                    name: 'aksi',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const detailUrl = `{{ url('dosen/log-mahasiswa') }}/${row.nim}`;
                        return `
                            <a href="${detailUrl}" class="btn btn-sm btn-outline-info me-2">
                                <i class="bi bi-info-circle me-1"></i> Lihat Detail
                            </a>
                            <button class="btn btn-sm btn-outline-warning btn-rate" 
                                data-id="${row.DT_RowIndex}"
                                data-nama="${row.nama}"
                                data-nim="${row.nim}">
                                <i class="bi bi-star me-1"></i> Beri Rating
                            </button>
                        `;
                    }
                }

            ]
        });

        // Initialize rating stars functionality
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

        // Handle rating button click
        $('#table-mahasiswa').on('click', '.btn-rate', function() {
            const studentId = $(this).data('id');
            const studentName = $(this).data('nama');
            const studentNim = $(this).data('nim');
            
            $('#studentId').val(studentId);
            $('#studentName').val(studentName);
            $('#studentNim').val(studentNim);
            
            // Reset form
            $('#ratingValue').val('');
            $('#studentComment').val('');
            stars.forEach(star => {
                star.classList.remove('bi-star-fill', 'active');
                star.classList.add('bi-star');
            });
            
            // Show modal
            var ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'));
            ratingModal.show();
        });

        // Handle submit rating
        $('#submitRating').click(function() {
            const studentId = $('#studentId').val();
            const studentName = $('#studentName').val();
            const rating = $('#ratingValue').val();
            const comment = $('#studentComment').val();
            
            if (!rating) {
                alert('Silakan beri rating terlebih dahulu');
                return;
            }
            
            // Here you would typically send the data to your server via AJAX
            console.log('Rating submitted:', {
                student_id: studentId,
                student_name: studentName,
                rating: rating,
                comment: comment
            });
            
            alert(`Rating ${rating} bintang untuk ${studentName} telah dikirim!`);
            
            // Close the modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
            modal.hide();
        });
    });
</script>
@endpush