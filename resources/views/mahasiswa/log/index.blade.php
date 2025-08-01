@extends('layouts.app')

@section('title', 'Log Magang | Sistem Rekomendasi Magang')

@section('content')
    <section class="card">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between my-6">
                <h4 class="mb-0">Log Magang</h4>
                <button class="btn btn-primary" onclick="modalAction('{{ url('log-kegiatan/create') }}')">
                    <i class="bx bx-plus"></i> Tambah Log
                </button>
            </div>

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        @forelse ($logs as $log)
                            <div class="col-md-12 mb-4">
                                <div class="card border border-light h-100">
                                    <div class="card-body position-relative">
                                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                                            <a href="#" class="btn btn-sm btn-icon text-warning" title="Edit"
                                                onclick="event.preventDefault(); modalAction('{{ url('log-kegiatan/' . $log->id_log . '/edit') }}')">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-icon text-danger" title="Delete"
                                                onclick="event.preventDefault(); confirmDelete('{{ url('log-kegiatan/' . $log->id_log) }}')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <div class="mb-3">
                                            <p class="fw-semibold mb-1">
                                                <i class="bi bi-calendar me-3"></i>{{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                            </p>
                                            <p class="fw-normal text-muted small mb-0">
                                                <i class="bi bi-clock me-2"></i>Minggu ke-{{ $log->minggu }}
                                            </p>
                                        </div>

                                        @if ($log->dokumen && $log->dokumen->count() > 0)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($log->dokumen as $dokumen)
                                                    <div class="position-relative" style="width: 150px;">
                                                        <img src="{{ asset($dokumen->path_file) }}" class="img-thumbnail"
                                                            style="max-height: 150px; width: 100%; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>Tidak ada gambar.</p>
                                        @endif

                                        <div class="border-top pt-2 mt-3">
                                            <p class="card-text small">
                                                {{ $log->deskripsi_kegiatan }}
                                            </p>
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
                                <div class="alert alert-info">Belum ada log kegiatan yang dicatat.</div>
                            </div>
                        @endforelse
                    </div>

                    @if ($logs->hasPages())
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mt-4">
                                <li class="page-item {{ $logs->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $logs->previousPageUrl() }}">Previous</a>
                                </li>

                                @foreach (range(1, $logs->lastPage()) as $i)
                                    <li class="page-item {{ $logs->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $logs->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ $logs->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $logs->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Container -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('scripts')
    <script>
        function modalAction(url) {
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Terjadi kesalahan');
                        });
                    }
                    return response.text();
                })
                .then(html => {
                    const modal = document.getElementById('myModal');
                    modal.innerHTML = html;
                    const bootstrapModal = new bootstrap.Modal(modal);
                    bootstrapModal.show();
                    
                    // Inisialisasi validasi setelah modal ditampilkan
                    initValidation();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Kamu belum terdaftar magang',
                        text: error.message,
                        timer: 5000,
                        showConfirmButton: true,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                });
        }

        function initValidation() {
            // Fungsi untuk menginisialisasi validasi pada form tertentu
            function setupFormValidation(formId) {
                if ($(`#${formId}`).length) {
                    // Tambahkan custom methods (hanya sekali)
                    if (!$.validator.methods.filesize) {
                        $.validator.addMethod("filesize", function(value, element, param) {
                            if (element.files.length === 0) return true;
                            
                            let totalSize = 0;
                            for (let i = 0; i < element.files.length; i++) {
                                totalSize += element.files[i].size;
                            }
                            return this.optional(element) || totalSize <= param;
                        }, "Ukuran total file terlalu besar.");
                    }

                    if (!$.validator.methods.maxfilecount) {
                        $.validator.addMethod("maxfilecount", function(value, element, max) {
                            return this.optional(element) || (element.files.length <= max && element.files.length > 0);
                        }, "Maksimal {0} file yang diperbolehkan dan minimal 1 file.");
                    }

                    // Aturan validasi yang sama untuk kedua form
                    const commonRules = {
                        tanggal: {
                            required: true
                        },
                        deskripsi_kegiatan: {
                            required: true,
                            minlength: 3
                        }
                    };

                    // Pesan error yang sama untuk kedua form
                    const commonMessages = {
                        tanggal: {
                            required: "Tanggal kegiatan wajib diisi."
                        },
                        deskripsi_kegiatan: {
                            required: "Deskripsi kegiatan wajib diisi.",
                            minlength: "Deskripsi minimal 3 karakter."
                        }
                    };

                    // Konfigurasi khusus untuk form tambah
                    if (formId === 'form-tambah') {
                        commonRules["images[]"] = {
                            required: true,
                            extension: "jpg|jpeg|png",
                            filesize: 2 * 1024 * 1024, // 2MB
                            maxfilecount: 5
                        };

                        commonMessages["images[]"] = {
                            required: "Minimal 1 gambar diperlukan.",
                            extension: "Hanya file gambar JPG, JPEG, atau PNG yang diperbolehkan.",
                            filesize: "Ukuran total maksimal 2MB.",
                            maxfilecount: "Maksimal 5 file yang diperbolehkan."
                        };
                    }

                    // Konfigurasi khusus untuk form edit
                    if (formId === 'form-edit') {
                        // Jika di form edit gambar tidak wajib diubah
                        commonRules["images[]"] = {
                            extension: "jpg|jpeg|png",
                            filesize: 2 * 1024 * 1024, // 2MB
                            maxfilecount: 5
                        };

                        commonMessages["images[]"] = {
                            extension: "Hanya file gambar JPG, JPEG, atau PNG yang diperbolehkan.",
                            filesize: "Ukuran total maksimal 2MB.",
                            maxfilecount: "Maksimal 5 file yang diperbolehkan."
                        };
                    }

                    // Inisialisasi validasi
                    $(`#${formId}`).validate({
                        ignore: [],
                        rules: commonRules,
                        messages: commonMessages,
                        errorPlacement: function(error, element) {
                            let id = element.attr('id');
                            $(`#error-${id}`).html(error);
                        },
                        highlight: function(element) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function(element) {
                            $(element).removeClass('is-invalid');
                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                }
            }

            // Setup validasi untuk kedua form
            setupFormValidation('form-tambah');
            setupFormValidation('form-edit');
        }

        // SweetAlert notifications
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                position: 'center' // ini bisa dihapus, karena default-nya memang center
            });
        @endif


        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 5000,
                showConfirmButton: true
            });
        @endif

        // You can also add this for delete confirmation
        function confirmDelete(url) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the delete form
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    data.message,
                                    'error'
                                );
                            }
                        });
                }
            });
        }
    </script>
@endpush
