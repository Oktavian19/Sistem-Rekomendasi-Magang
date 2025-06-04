<div class="row">
    <div class="col-12">
        <h4>Informasi Magang</h4>
        <table class="table table-sm">
            <tr>
                <th width="30%">Status Magang</th>
                <td>
                    <span class="badge 
                        @if($magang->status_magang == 'aktif') bg-label-success
                        @elseif($magang->status_magang == 'batal') bg-label-danger
                        @else bg-label-warning @endif">
                        {{ ucfirst($magang->status_magang) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Tanggal Mulai</th>
                <td>{{ $magang->tanggal_mulai ? \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Selesai</th>
                <td>{{ $magang->tanggal_selesai ? \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Dosen Pembimbing</th>
                <td>
                    @if($magang->dosenPembimbing)
                        {{ $magang->dosenPembimbing->nama }} ({{ $magang->dosenPembimbing->nidn }})
                    @else
                        Belum ada dosen pembimbing
                    @endif
                </td>
            </tr>
            <tr>
                <th>Periode Magang</th>
                <td>{{ $magang->periodeMagang->nama_periode ?? '-' }}</td>
            </tr>
            <tr>
                <th>Sertifikat</th>
                <td>
                    @if($magang->path_sertifikat)
                        <a href="{{ asset('storage/' . $magang->path_sertifikat) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="bx bx-download"></i> Unduh Sertifikat
                        </a>
                    @else
                        Belum ada sertifikat
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>