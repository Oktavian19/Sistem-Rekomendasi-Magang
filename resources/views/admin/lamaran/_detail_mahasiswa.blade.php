<div class="row">
    <div class="col-md-12">
        <h5>Informasi Mahasiswa</h5>
        <div class="mb-3">
            <table class="table table-sm table-borderless">
                <tr>
                    <th width="35%">Nama</th>
                    <td>{{ $lamaran->mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td>{{ $lamaran->mahasiswa->nim }}</td>
                </tr>
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $lamaran->mahasiswa->program_studi->nama_prodi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $lamaran->mahasiswa->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No. HP</th>
                    <td>{{ $lamaran->mahasiswa->no_hp ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>