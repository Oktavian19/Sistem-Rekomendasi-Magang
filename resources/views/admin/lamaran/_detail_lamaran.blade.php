<div class="row">
    <div class="col-12">
        <h5>Detail Lamaran</h5>
        <div class="mb-3">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="20%">Tanggal Lamar</th>
                    <td>{{ \Carbon\Carbon::parse($lamaran->tanggal_lamaran)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span
                            class="badge 
                            @if ($lamaran->status_lamaran == 'diterima') bg-success 
                            @elseif($lamaran->status_lamaran == 'ditolak') bg-danger 
                            @else bg-warning text-dark @endif">
                            {{ ucfirst($lamaran->status_lamaran) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Dari Rekomendasi</th>
                    <td>{{ $lamaran->dari_rekomendasi ? 'Ya' : 'Tidak' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
