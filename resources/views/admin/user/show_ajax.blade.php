<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>Username</th>
                    <td>{{ $user->username }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ ucfirst($user->role) }}</td>
                </tr>

                @if ($user->role === 'admin' && $detail)
                    <tr>
                        <th>Nama</th>
                        <td>{{ $detail->nama }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $detail->email }}</td>
                    </tr>
                @elseif ($user->role === 'mahasiswa' && $detail)
                    <tr>
                        <th>Nama</th>
                        <td>{{ $detail->nama }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $detail->nim }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $detail->email }}</td>
                    </tr>
                @elseif ($user->role === 'dosen_pembimbing' && $detail)
                    <tr>
                        <th>Nama</th>
                        <td>{{ $detail->nama }}</td>
                    </tr>
                    <tr>
                        <th>NIDN</th>
                        <td>{{ $detail->nidn }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $detail->email }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" class="text-center text-muted">Data detail tidak tersedia.</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
