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

        <!-- Pengalaman Kerja Section -->
        <h5>Pengalaman Kerja</h5>
        @if ($lamaran->mahasiswa->pengalamanKerja->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Posisi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lamaran->mahasiswa->pengalamanKerja as $pengalaman)
                            <tr>
                                <td>{{ $pengalaman->perusahaan }}</td>
                                <td>{{ $pengalaman->nama_posisi }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengalaman->tanggal_mulai)->translatedFormat('d F Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pengalaman->tanggal_selesai)->translatedFormat('d F Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">Mahasiswa belum memiliki pengalaman kerja</div>
        @endif

        <!-- Dokumen Section -->
        <h5 class="mt-4">Dokumen Pendukung</h5>
        @if ($lamaran->mahasiswa->dokumen->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Jenis Dokumen</th>
                            <th>File</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lamaran->mahasiswa->dokumen as $dokumen)
                            <tr>
                                <td>{{ $dokumen->jenis_dokumen }}</td>
                                <td>
                                    @php
                                        $filename = basename($dokumen->path_file);
                                    @endphp
                                    {{ $filename }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank"
                                        class="btn btn-sm btn-info" title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">Mahasiswa belum mengunggah dokumen pendukung</div>
        @endif
    </div>
</div>
