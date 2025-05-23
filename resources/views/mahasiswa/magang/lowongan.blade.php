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
                    <div class="card mb-4 py-5">
                        <div class="card-header d-flex d-lg-none">
                            <div class="fw-bold">Filter</div>
                            <button class="btn btn-sm ms-auto"><i class="bi bi-sliders"></i></button>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('lowongan/index') }}">
                                <span class="text-black">Kata Kunci</span>
                                <div class="mb-5 mt-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="keyword" placeholder="Cari"
                                            value="{{ request('keyword') }}">

                                    </div>
                                </div>

                                <span class="mt-4 text-black">Lokasi</span>
                                <div class="mb-5 mt-2">
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

                                <span class="mt-4 text-black">Bidang Pekerjaan</span>
                                <div class="mb-5 mt-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-folder"></i></span>
                                        <select class="form-select" name="job_field_id">
                                            <option value="">Semua</option>
                                            @foreach ($bidangKeahlians as $bidang)
                                                <option value="{{ $bidang->id }}"
                                                    {{ request('job_field_id') == $bidang->id_bidang_keahlian ? 'selected' : '' }}>
                                                    {{ $bidang->nama_bidang }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <span class="mt-5 text-black">Kuota</span>
                                <div class="list-group mt-2">
                                    <label class="list-group-item d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="quota_range[]"
                                            value="1-5"
                                            {{ in_array('1-5', request('quota_range', [])) ? 'checked' : '' }}>
                                        1–5 orang
                                    </label>
                                    <label class="list-group-item d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="quota_range[]"
                                            value="6-10"
                                            {{ in_array('6-10', request('quota_range', [])) ? 'checked' : '' }}>

                                        6–10 orang
                                    </label>
                                    <label class="list-group-item d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="quota_range[]"
                                            value="11-20"
                                            {{ in_array('11-20', request('quota_range', [])) ? 'checked' : '' }}>

                                        11–20 orang
                                    </label>
                                    <label class="list-group-item d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="quota_range[]"
                                            value="21-50"
                                            {{ in_array('21-50', request('quota_range', [])) ? 'checked' : '' }}>

                                        21–50 orang
                                    </label>
                                    <label class="list-group-item d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" name="quota_range[]"
                                            value="51+"
                                            {{ in_array('51+', request('quota_range', [])) ? 'checked' : '' }}>
                                        >50 orang
                                    </label>
                                </div>


                                <button type="submit" class="btn btn-primary w-100 mt-4">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-9">
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
                                                    <i class="bi bi-building me-1"></i>{{ $lowongan->perusahaan->nama_perusahaan ?? '-' }}
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
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Tidak ada lowongan ditemukan.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">
                            {{ $lowongans->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('sort').addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        window.location.href = url.toString();
    });
</script>
@endpush