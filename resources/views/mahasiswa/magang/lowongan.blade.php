@extends('layouts.app')

@section('title', 'Lowongan | Sistem Rekomendasi Magang')

@section('content')
    <section class="">
        <div class="container">
            <div class="row justify-content-between align-items-center mb-4">
                <div class="col-auto">
                    <h3 class="fw-bold">Lowongan Pekerjaan</h3>
                    <span class="text-muted">Tersedia</span> {{ $total }} <span class="text-muted">Lowongan</span>
                </div>
                <div class="col-auto">
                    <select class="form-select" name="sort" id="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Urutkan Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Urutkan Terlama</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Urutkan A - Z
                        </option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Urutkan Z - A
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xl-3 mb-4">
                    <div class="card mb-4">
                        <div class="card-header d-flex d-lg-none align-items-center">
                            <div class="fw-bold">Filter</div>
                            <button class="btn btn-sm ms-auto" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                                <i class="bi bi-sliders"></i>
                            </button>
                        </div>
                        <div class="card-body collapse d-lg-block pt-5" id="filterCollapse">
                            <form method="GET" action="{{ url('/daftar-lowongan') }}">
                                <span class="text-black fw-bold">Kata Kunci</span>
                                <div class="mb-4 mt-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="keyword" placeholder="Cari"
                                            value="{{ request('keyword') }}">
                                    </div>
                                </div>

                                <span class="mt-4 text-black fw-bold">Lokasi</span>
                                <div class="mb-4 mt-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <select name="lokasi" class="form-select">
                                            <option value="">Semua Kota</option>
                                            @foreach ($kotas as $kota)
                                                <option value="{{ $kota }}"
                                                    {{ request('lokasi') == $kota ? 'selected' : '' }}>
                                                    {{ $kota }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <span class="mt-4 text-black fw-bold">Bidang Pekerjaan</span>
                                <div class="mb-4 mt-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-folder"></i></span>
                                        <select class="form-select" name="job_field_id">
                                            <option value="">Semua Bidang</option>
                                            @foreach ($bidangKeahlians as $bidang)
                                                <option value="{{ $bidang->id }}"
                                                    {{ request('job_field_id') == $bidang->id ? 'selected' : '' }}>
                                                    {{ $bidang->label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <span class="mt-4 text-black fw-bold">Kuota</span>
                                <div class="mb-4 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quota_range" value="1-5"
                                            id="quota1-5" {{ request('quota_range') == '1-5' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="quota1-5">
                                            1–5 orang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quota_range" value="6-10"
                                            id="quota6-10" {{ request('quota_range') == '6-10' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="quota6-10">
                                            6–10 orang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quota_range" value="11-20"
                                            id="quota11-20" {{ request('quota_range') == '11-20' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="quota11-20">
                                            11–20 orang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quota_range" value="21-50"
                                            id="quota21-50" {{ request('quota_range') == '21-50' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="quota21-50">
                                            21–50 orang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quota_range" value="51+"
                                            id="quota51plus" {{ request('quota_range') == '51+' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="quota51plus">
                                            >50 orang
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                    <a href="{{ url('/daftar-lowongan') }}" class="btn btn-outline-secondary me-md-2">
                                        Reset
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Terapkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-9">
                    @if (request()->has('keyword') ||
                            request()->has('lokasi') ||
                            request()->has('job_field_id') ||
                            request()->has('quota_range'))
                        <div class="alert alert-info mb-4">
                            Menampilkan hasil filter:
                            <ul class="mb-0">
                                @if (request('keyword'))
                                    <li>Kata kunci: "{{ request('keyword') }}"</li>
                                @endif
                                @if (request('lokasi'))
                                    <li>Lokasi: {{ request('lokasi') }}</li>
                                @endif
                                @if (request('job_field_id'))
                                    @php
                                        $selectedField = $bidangKeahlians->firstWhere(
                                            'id',
                                            request('job_field_id'),
                                        );
                                    @endphp
                                    <li>Bidang: {{ $selectedField->label ?? '' }}</li>
                                @endif
                                @if (request('quota_range'))
                                    <li>Kuota: {{ request('quota_range') }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        @forelse ($lowongans as $lowongan)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <img src="{{ $lowongan->perusahaan->path_logo ?? 'https://via.placeholder.com/60' }}"
                                                alt="Company Logo" class="rounded me-3" width="60" height="60">
                                            <div>
                                                <h5 class="card-title mb-1">{{ $lowongan->nama_posisi }}</h5>
                                                <p class="card-text text-muted small mb-1">
                                                    <i
                                                        class="bi bi-building me-1"></i>{{ $lowongan->perusahaan->nama_perusahaan ?? '-' }}
                                                </p>
                                                <p class="card-text text-muted small">
                                                    <i class="bi bi-geo-alt me-1"></i>{{ $lowongan->perusahaan->alamat }}
                                                    <i class="bi bi-briefcase ms-2 me-1"></i>Kuota: {{ $lowongan->kuota }}
                                                    orang
                                                </p>
                                            </div>
                                        </div>
                                        <div class="border-top pt-2">
                                            <p class="card-text small">
                                                <i class="bi bi-clock me-1"></i>Akhir Pendaftaran
                                                {{ \Carbon\Carbon::parse($lowongan->tanggal_akhir)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <a href="{{ url('daftar-lowongan', $lowongan->id_lowongan) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    Tidak ada lowongan yang sesuai dengan kriteria filter Anda.
                                    <a href="{{ url('/daftar-lowongan') }}" class="alert-link">Reset filter</a> untuk
                                    melihat semua lowongan.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">
                            {{ $lowongans->appends(request()->query())->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.getElementById('sort').addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });

        // Untuk tampilan mobile, buka filter secara default jika ada filter aktif
        document.addEventListener('DOMContentLoaded', function() {
            const hasActiveFilters = @json(request()->has('keyword') ||
                    request()->has('lokasi') ||
                    request()->has('job_field_id') ||
                    request()->has('quota_range'));

            if (hasActiveFilters && window.innerWidth < 992) {
                const collapseElement = document.getElementById('filterCollapse');
                if (collapseElement) {
                    new bootstrap.Collapse(collapseElement, {
                        toggle: true
                    });
                }
            }
        });
    </script>
@endpush
