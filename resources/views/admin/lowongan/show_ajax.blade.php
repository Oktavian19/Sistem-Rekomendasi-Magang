<div id="modal-show-lowongan" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Lowongan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Perusahaan</th>
                    <td>{{ $lowongan->perusahaan->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <th>Nama Posisi</th>
                    <td>{{ $lowongan->nama_posisi }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $lowongan->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Kategori Keahlian</th>
                    <td>
                        @if ($lowongan->bidangKeahlian->isNotEmpty())
                            <ul class="mb-0 ps-3">
                                @foreach ($lowongan->bidangKeahlian as $bidang)
                                    <li>{{ $bidang->label }}</li>
                                @endforeach
                            </ul>
                        @else
                            <em>Tidak ada</em>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Fasilitas</th>
                    <td>
                        @if ($lowongan->fasilitas->isNotEmpty())
                            <ul class="mb-0 ps-3">
                                @foreach ($lowongan->fasilitas as $fasilitas)
                                    <li>{{ $fasilitas->label }}</li>
                                @endforeach
                            </ul>
                        @else
                            <em>Tidak ada</em>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Jenis Pelaksanaan</th>
                    <td>{{ $lowongan->jenisPelaksanaan->label ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kuota</th>
                    <td>{{ $lowongan->kuota }}</td>
                </tr>
                <tr>
                    <th>Persyaratan</th>
                    <td>{{ $lowongan->persyaratan }}</td>
                </tr>
                <tr>
                    <th>Tanggal Buka</th>
                    <td>{{ \Carbon\Carbon::parse($lowongan->tanggal_buka)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Tutup</th>
                    <td>{{ \Carbon\Carbon::parse($lowongan->tanggal_tutup)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Durasi Magang</th>
                    <td>{{ $lowongan->durasiMagang->label ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
