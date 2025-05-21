<div id="modal-show-user" class="modal-dialog modal-lg" role="document">
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
                <tr>;
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
                    <tr>
                        <th>No HP</th>
                        <td>{{ $detail->no_hp }}</td>
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
                    <tr>
                        <th>No HP</th>
                        <td>{{ $detail->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Program Studi</th>
                        <td>{{ $detail->programStudi->nama_program_studi ?? '-' }}</td>
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
                    <tr>
                        <th>No HP</th>
                        <td>{{ $detail->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Bidang Minat</th>
                        <td>{{ $detail->bidang_minat }}</td>
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
<script>
    $(document).on('click', '.btn-detail', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/user/' + id + '/show-ajax',
            type: 'GET',
            success: function (response) {
                $('#modalDetailUser .modal-content').html(response);
                $('#modalDetailUser').modal('show');
            },
            error: function () {
                alert('Gagal memuat detail pengguna.');
            }
        });
    });
</script>