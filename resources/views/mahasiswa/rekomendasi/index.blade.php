@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Proses SPK Rekomendasi Lowongan Magang</h2>

        {{-- Matriks Alternatif --}}
        <div class="mb-5">
            <h4>Matriks Alternatif</h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Lowongan</th>
                        <th>Jarak</th>
                        <th>Durasi Magang</th>
                        <th>Jenis Pelaksanaan</th>
                        <th>Jenis Perusahaan</th>
                        <th>Bidang Keahlian</th>
                        <th>Fasilitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matriksAlternatif as $idLowongan => $data)
                        <tr>
                            <td>[{{ $idLowongan }}] {{ $data['posisi'] }} ({{ $data['perusahaan'] }})</td>
                            @foreach ($data['kriteria'] as $nilai)
                                <td>{{ $nilai }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Normalisasi Min-Max --}}
        <div class="mb-5">
            <h4>Normalisasi Min-Max</h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Lowongan</th>
                        <th>Jarak</th>
                        <th>Durasi Magang</th>
                        <th>Jenis Pelaksanaan</th>
                        <th>Jenis Perusahaan</th>
                        <th>Bidang Keahlian</th>
                        <th>Fasilitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($normalisasiMinMax as $idLowongan => $kriteria)
                        @php
                            $namaPerusahaan = $matriksAlternatif[$idLowongan]['perusahaan'] ?? '-';
                            $namaPosisi = $matriksAlternatif[$idLowongan]['posisi'] ?? '-';
                        @endphp
                        <tr>
                            <td>[{{ $idLowongan }}] {{ $namaPosisi }} ({{ $namaPerusahaan }})</td>
                            @foreach ($kriteria as $nilai)
                                <td>{{ number_format($nilai, 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Bobot CRITIC --}}
        <div class="mb-5">
            <h4>Bobot CRITIC</h4>
            <table class="table table-bordered table-sm w-auto">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $kriteriaLabels = [
                            'Jarak',
                            'Durasi Magang',
                            'Jenis Pelaksanaan',
                            'Jenis Perusahaan',
                            'Bidang Keahlian',
                            'Fasilitas',
                        ];
                    @endphp
                    @foreach ($bobotCritic as $index => $bobot)
                        <tr>
                            <td>{{ $kriteriaLabels[$index] ?? 'Kriteria ' . $index }}</td>
                            <td>{{ number_format($bobot, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Normalisasi Benefit --}}
        <div class="mb-5">
            <h4>Normalisasi Benefit</h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Lowongan</th>
                        <th>Jarak</th>
                        <th>Durasi Magang</th>
                        <th>Jenis Pelaksanaan</th>
                        <th>Jenis Perusahaan</th>
                        <th>Bidang Keahlian</th>
                        <th>Fasilitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($normalisasiBenefit as $idLowongan => $kriteria)
                        @php
                            $namaPerusahaan = $matriksAlternatif[$idLowongan]['perusahaan'] ?? '-';
                            $namaPosisi = $matriksAlternatif[$idLowongan]['posisi'] ?? '-';
                        @endphp
                        <tr>
                            <td>[{{ $idLowongan }}] {{ $namaPosisi }} ({{ $namaPerusahaan }})</td>
                            @foreach ($kriteria as $nilai)
                                <td>{{ number_format($nilai, 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Hasil WASPAS --}}
        <div class="mb-5">
            <h4>Hasil Akhir WASPAS</h4>
            <table class="table table-bordered table-sm w-auto">
                <thead>
                    <tr>
                        <th>Lowongan</th>
                        <th>Nilai</th>
                        <th>Ranking</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rank = 1; @endphp
                    @foreach ($hasilWaspas as $idLowongan => $nilai)
                        @php
                            $namaPerusahaan = $matriksAlternatif[$idLowongan]['perusahaan'] ?? '-';
                            $namaPosisi = $matriksAlternatif[$idLowongan]['posisi'] ?? '-';
                        @endphp
                        <tr>
                            <td>[{{ $idLowongan }}] {{ $namaPosisi }} ({{ $namaPerusahaan }})</td>
                            <td>{{ number_format($nilai, 4) }}</td>
                            <td>{{ $rank++ }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
