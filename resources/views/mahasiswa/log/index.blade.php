@extends('layouts.app')

@section('title', 'Log Magang | Sistem Rekomendasi Magang')

@section('content')

    <section class="card">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between my-6">
                <h4 class="mb-0">Log Magang</h4>
                <a href="{{ url('log-kegiatan/create') }}" class="btn btn-primary"
                    onclick="modalAction(this.href); return false;">+ Tambah Log</a>
            </div>

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        @forelse ($logs as $log)
                            <!-- Job Listing -->
                            <div class="col-md-12 mb-4">
                                <div class="card border border-light h-100">
                                    <div class="card-body position-relative">
                                        <!-- Action Buttons -->
                                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                                            <a href="" class="btn btn-sm btn-icon text-warning" title="Edit"
                                                onclick="modalAction('{{ url('log-kegiatan/' . $log->id_log . '/edit') }}')">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="" class="btn btn-sm btn-icon text-danger" title="Delete"
                                                onclick="modalAction('{{ url('log-kegiatan/' . $log->id_lod . '/confirm-delete') }}')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Date Section -->
                                        <div class="mb-3">
                                            <p class="fw-semibold mb-1">
                                                <i
                                                    class="bi bi-calendar me-3"></i>{{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}
                                            </p>
                                        </div>

                                        <!-- Image Gallery -->
                                        {{-- In your edit view --}}
                                        @if ($log->dokumen && $log->dokumen->count() > 0)
                                            @foreach ($log->dokumen as $dokumen)
                                                <div class="col-md-4 mb-2">
                                                    <div class="position-relative">
                                                        <img src="{{ asset($dokumen->path_file) }}" class="img-thumbnail"
                                                            style="max-height: 150px;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image"
                                                            data-image-id="{{ $dokumen->id_log }}">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Tidak ada gambar</p>
                                        @endif

                                        <!-- Description Section -->
                                        <div class="border-top pt-2">
                                            <p class="card-text small">
                                                {{ $log->deskripsi_kegiatan }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    Belum ada log kegiatan yang dicatat.
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
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
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
        </div>
    </section>
@endsection

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" aria-hidden="true">
</div>

@push('scripts')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
    </script>
@endpush
