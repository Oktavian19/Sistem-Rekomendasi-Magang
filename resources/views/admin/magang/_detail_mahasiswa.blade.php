<div class="row">
    <div class="col-md-4">
        <div class="text-center mb-3">
            @if($magang->lamaran->mahasiswa->foto_profil)
                <img src="{{ asset('storage/' . $magang->lamaran->mahasiswa->foto_profil) }}" 
                     class="rounded-circle img-thumbnail" width="150" height="150" alt="Foto Profil">
            @else
                <div class="avatar avatar-xl rounded-circle bg-label-secondary">
                    <span class="avatar-initials">
                        {{ substr($magang->lamaran->mahasiswa->nama, 0, 1) }}
                    </span>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <h4>{{ $magang->lamaran->mahasiswa->nama }}</h4>
        <table class="table table-sm">
            <tr>
                <th width="30%">NIM</th>
                <td>{{ $magang->lamaran->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td>{{ $magang->lamaran->mahasiswa->programStudi->nama_program_studi ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $magang->lamaran->mahasiswa->user->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. HP</th>
                <td>{{ $magang->lamaran->mahasiswa->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $magang->lamaran->mahasiswa->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $magang->lamaran->mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
        </table>
    </div>
</div>