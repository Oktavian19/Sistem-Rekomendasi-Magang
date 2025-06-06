<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Users, Admin, Mahasiswa, DosenPembimbing, ProgramStudi};
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\UserActivated;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use PDF;


class KelolaPenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Users::all();
        // Hitung total berdasarkan role
        $totalUser = Users::count();
        $totalAdmin = Users::where('role', 'admin')->count();
        $totalDosen = Users::where('role', 'dosen_pembimbing')->count();
        $totalMahasiswa = Users::where('role', 'mahasiswa')->count();

        return view('admin.user.index', compact(
            'pengguna',
            'totalUser',
            'totalAdmin',
            'totalDosen',
            'totalMahasiswa'
        ));
    }

    public function list(Request $request)
    {
        $users = Users::select([
            'users.id_user',
            'users.username',
            'users.role',
            'users.status',
            DB::raw("
        CASE 
            WHEN users.role = 'admin' THEN admin.nama
            WHEN users.role = 'mahasiswa' THEN mahasiswa.nama
            WHEN users.role = 'dosen_pembimbing' THEN dosen_pembimbing.nama
            ELSE NULL
        END as nama
    ")
        ])
            ->leftJoin('admin', 'admin.id_admin', '=', 'users.id_user')
            ->leftJoin('mahasiswa', 'mahasiswa.id_mahasiswa', '=', 'users.id_user')
            ->leftJoin('dosen_pembimbing', 'dosen_pembimbing.id_dosen_pembimbing', '=', 'users.id_user');

        if ($request->has('id_user')) {
            $users->where('id_user', $request->id_user);
        }

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $users->where('users.role', $request->role);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('status', function ($user) {
                $class = $user->status === 'aktif' ? 'badge bg-success' : 'badge bg-secondary';
                return '<span class="' . $class . '">' . ucfirst($user->status) . '</span>';
            })
            ->addColumn('aksi_status', function ($user) {
                $btn = '<form method="POST" action="' . url('user/toggle-status/' . $user->id_user) . '" class="d-inline toggle-status-form">';
                $btn .= csrf_field();
                $btn .= '<button type="submit" class="btn btn-sm ' . ($user->status == 'aktif' ? 'btn-warning' : 'btn-success') . '">';
                $btn .= $user->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan';
                $btn .= '</button>';
                $btn .= '</form>';
                return $btn;
            })            
            ->addColumn('aksi', function ($user) {
                $btn  = '<div class="dropdown">';
                $btn .= '<a href="#" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false">';
                $btn .= '<i class="bx bx-dots-vertical-rounded"></i>';
                $btn .= '</a>';
                $btn .= '<ul class="dropdown-menu">';

                // Detail link
                $btn .= '<li><a class="dropdown-item" href="' . url('user/' . $user->id_user . '/show-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-show-alt"></i> Detail';
                $btn .= '</a></li>';

                // Edit link
                $btn .= '<li><a class="dropdown-item" href="' . url('user/' . $user->id_user . '/edit-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-edit-alt"></i> Edit';
                $btn .= '</a></li>';

                // Delete link
                $btn .= '<li><a class="dropdown-item" href="' . url('user/' . $user->id_user  . '/confirm-ajax') . '" onclick="modalAction(this.href); return false;">';
                $btn .= '<i class="bx bx-trash"></i> Hapus';
                $btn .= '</a></li>';

                $btn .= '</ul>';
                $btn .= '</div>';

                return $btn;
            })
            ->filterColumn('nama', function ($query, $keyword) {
                $query->whereRaw("LOWER(
            CASE 
                WHEN users.role = 'admin' THEN admin.nama
                WHEN users.role = 'mahasiswa' THEN mahasiswa.nama
                WHEN users.role = 'dosen_pembimbing' THEN dosen_pembimbing.nama
                ELSE ''
            END
        ) LIKE ?", ["%" . strtolower($keyword) . "%"]);
            })
            ->filterColumn('role', function ($query, $keyword) {
                $query->whereRaw("LOWER(users.role) LIKE ?", ["%" . strtolower($keyword) . "%"]);
            })
            ->filterColumn('username', function ($query, $keyword) {
                $query->whereRaw("LOWER(users.username) LIKE ?", ["%" . strtolower($keyword) . "%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->whereRaw("LOWER(users.status) LIKE ?", ["%" . strtolower($keyword) . "%"]);
            })            
            ->rawColumns(['aksi', 'status', 'aksi_status'])
            ->make(true);
    }

    public function create_ajax()
    {
        $roles = ['admin', 'mahasiswa', 'dosen_pembimbing'];
        $programStudi = ProgramStudi::all();

        return view('admin.user.create_ajax', compact('roles', 'programStudi'));
    }

    public function store_ajax(Request $request)
    {
        // Common validation rules
        $rules = [
            'username' => 'required|string|min:3|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,mahasiswa,dosen_pembimbing',
            'nama'     => 'required|string|max:100',
            'no_hp'    => 'required|string|max:20',
        ];

        // Role-specific validation rules
        switch ($request->role) {
            case 'mahasiswa':
                $rules['nim'] = 'required|string|unique:mahasiswa,nim';
                $rules['id_program_studi'] = 'required|exists:program_studi,id_program_studi';
                $rules['email'] = 'required|email|unique:mahasiswa,email';
                break;
            case 'dosen_pembimbing':
                $rules['nidn'] = 'required|string|unique:dosen_pembimbing,nidn';
                $rules['bidang_minat'] = 'required|string';
                $rules['email'] = 'required|email|unique:dosen_pembimbing,email';
                break;
            case 'admin':
                $rules['email'] = 'required|email|unique:admin,email';
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        // Create user first
        $user = Users::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => $request->role
        ]);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan user',
            ]);
        }

        switch ($request->role) {
            case 'admin':
                Admin::create([
                    'id_admin' => $user->id_user,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp
                ]);
                break;

            case 'mahasiswa':
                Mahasiswa::create([
                    'id_mahasiswa' => $user->id_user,
                    'nim' => $request->nim,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                    'id_program_studi' => $request->id_program_studi
                ]);
                break;

            case 'dosen_pembimbing':
                DosenPembimbing::create([
                    'id_dosen_pembimbing' => $user->id_user,
                    'nidn' => $request->nidn,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                    'bidang_minat' => $request->bidang_minat
                ]);
                break;
        }


        return response()->json([
            'status'  => true,
            'message' => 'Data user berhasil disimpan',
        ]);
    }

    public function edit_ajax(string $id)
    {
        $user = Users::find($id);
        $roles = ['admin', 'mahasiswa', 'dosen_pembimbing'];
        $programStudi = ProgramStudi::all();

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        switch ($user->role) {
            case 'mahasiswa':
                $detail = Mahasiswa::where('id_mahasiswa', $user->id_user)->first();
                break;
            case 'admin':
                $detail = Admin::where('id_admin', $user->id_user)->first();
                break;
            case 'dosen_pembimbing':
                $detail = DosenPembimbing::where('id_dosen_pembimbing', $user->id_user)->first();
                break;
        }

        return view('admin.user.edit_ajax', compact(
            'user',
            'roles',
            'detail',
            'programStudi',
        ));
    }

    public function update_ajax(Request $request, $id)
    {
        $user = Users::find($id);
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Common validation rules
        $rules = [
            'username' => 'required|max:50|unique:users,username,' . $id . ',id_user',
            'password' => 'nullable|min:6|max:100',
            'role'     => 'required|in:admin,mahasiswa,dosen_pembimbing',
            'nama'     => 'required|string|max:100',
            'no_hp'    => 'required|string|max:20',
        ];

        // Role-specific validation rules
        switch ($request->role) {
            case 'mahasiswa':
                $rules['nim'] = 'required|string|unique:mahasiswa,nim,' . $user->id_user . ',id_mahasiswa';
                $rules['id_program_studi'] = 'required|exists:program_studi,id_program_studi';
                $rules['email'] = 'required|email|unique:mahasiswa,email,' . $user->id_user . ',id_mahasiswa';
                break;
            case 'dosen_pembimbing':
                $rules['nidn'] = 'required|string|unique:dosen_pembimbing,nidn,' . $user->id_user . ',id_dosen_pembimbing';
                $rules['bidang_minat'] = 'required|string';
                $rules['email'] = 'required|email|unique:dosen_pembimbing,email,' . $user->id_user . ',id_dosen_pembimbing';
                break;
            case 'admin':
                $rules['email'] = 'required|email|unique:admin,email,' . $user->id_user . ',id_admin';
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors(),
            ], 422);
        }

        // Update user
        $user->update([
            'username' => $request->username,
            'role'     => $request->role,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
        ]);

        // Update role-specific data
        switch ($user->role) {
            case 'mahasiswa':
                $mahasiswa = Mahasiswa::updateOrCreate(
                    ['id_mahasiswa' => $user->id_user],
                    [
                        'nim' => $request->nim,
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'id_program_studi' => $request->id_program_studi
                    ]
                );
                break;

            case 'admin':
                Admin::updateOrCreate(
                    ['id_admin' => $user->id_user],
                    [
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp
                    ]
                );
                break;

            case 'dosen_pembimbing':
                DosenPembimbing::updateOrCreate(
                    ['id_dosen_pembimbing' => $user->id_user],
                    [
                        'nidn' => $request->nidn,
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp,
                        'bidang_minat' => $request->bidang_minat
                    ]
                );
                break;
        }

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function show_ajax($id)
    {
        $user = Users::findOrFail($id);
        $detail = null;

        switch ($user->role) {
            case 'admin':
                $detail = Admin::where('id_admin', $user->id_user)->first();
                break;
            case 'mahasiswa':
                $detail = Mahasiswa::where('id_mahasiswa', $user->id_user)->first();
                break;
            case 'dosen_pembimbing':
                $detail = DosenPembimbing::where('id_dosen_pembimbing', $user->id_user)->first();
                break;
        }

        return view('admin.user.show_ajax', compact('user', 'detail'));
    }



    public function confirm_ajax(string $id)
    {
        $user = Users::find($id);

        $detail = null;

        switch ($user->role) {
            case 'admin':
                $detail = Admin::where('id_admin', $user->id_user)->first();
                break;
            case 'mahasiswa':
                $detail = Mahasiswa::where('id_mahasiswa', $user->id_user)->first();
                break;
            case 'dosen_pembimbing':
                $detail = DosenPembimbing::where('id_dosen_pembimbing', $user->id_user)->first();
                break;
        }

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.user.confirm_ajax', compact('user', 'detail'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }

    public function resetPasswordForm($id)
    {
        $user = Users::findOrFail($id);
        return view('admin.user.reset_password', compact('user'));
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed', // pakai input password_confirmation
        ]);

        $user = Users::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/admin/user')->with('success', 'Password berhasil direset.');
    }

    public function toggleStatus($id)
    {
        $user = Users::findOrFail($id);
        $user->status = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();

        // Ambil email berdasarkan role
        $email = null;

        switch ($user->role) {
            case 'mahasiswa':
                $mahasiswa = \App\Models\Mahasiswa::where('id_mahasiswa', $user->id_user)->first();
                $email = $mahasiswa->email ?? null;
                break;
            case 'admin':
                $admin = \App\Models\Admin::where('id_admin', $user->id_user)->first();
                $email = $admin->email ?? null;
                break;
            case 'dosen_pembimbing':
                $dosen = \App\Models\DosenPembimbing::where('id_dosen_pembimbing', $user->id_user)->first();
                $email = $dosen->email ?? null;
                break;
        }

        // Kirim email jika email ditemukan dan status aktif
        if ($user->status === 'aktif' && $email) {
            Mail::to($email)->send(new UserActivated($user));
        }

        return response()->json([
            'status' => true,
            'message' => 'Status akun berhasil diubah menjadi ' . $user->status
        ]);
    }

    public function export_excel(Request $request)
    {
        $role = $request->query('role');
        
        $fileName = 'data_pengguna_' . date('Ymd_His') . '.xlsx';
        
        return Excel::download(new UsersExport($role), $fileName);
    }

    public function export_pdf(Request $request)
    {
        $role = $request->query('role');
        
        $query = Users::query()->with(['mahasiswa', 'admin', 'dosenPembimbing']);
        
        if ($role) {
            $query->where('role', $role);
        }
        
        $data = $query->get()->map(function($user) {
            return [
                'username' => $user->username,
                'nama' => $this->getNamaUser($user),
                'role' => $this->formatRole($user->role),
                'status' => $user->status ? 'Aktif' : 'Nonaktif'
            ];
        });
        
        $pdf = PDF::loadView('exports.users-pdf', [
            'data' => $data,
            'filter' => $role ? 'Role: ' . $this->formatRole($role) : 'Semua Data'
        ]);
        
        return $pdf->download('data_pengguna_' . date('Ymd_His') . '.pdf');
    }

    private function getNamaUser($user)
    {
        switch ($user->role) {
            case 'mahasiswa':
                return $user->mahasiswa->nama ?? '-';
            case 'admin':
                return $user->admin->nama ?? '-';
            case 'dosen_pembimbing':
                return $user->dosenPembimbing->nama ?? '-';
            default:
                return '-';
        }
    }

    private function formatRole($role)
    {
        $roles = [
            'admin' => 'Admin',
            'dosen_pembimbing' => 'Dosen Pembimbing',
            'mahasiswa' => 'Mahasiswa'
        ];
        
        return $roles[$role] ?? $role;
    }
}
