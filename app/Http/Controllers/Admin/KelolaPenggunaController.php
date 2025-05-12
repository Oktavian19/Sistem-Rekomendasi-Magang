<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KelolaPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users::all();
        return view('admin.user.index', compact('users'));
    }


    public function list(Request $request)
    {
        $users = Users::select('id_user', 'username', 'role');

        if ($request->role) {
            $users->where('role', $request->role);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $btn  = '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $roles = ['admin', 'mahasiswa', 'dosen_pembimbing'];
        return view('admin.user.create_ajax', compact('roles'));
    }

    public function store_ajax(Request $request)
    {
        $rules = [
            'username' => 'required|string|min:3|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,mahasiswa,dosen_pembimbing',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        Users::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => $request->role
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data user berhasil disimpan',
        ]);
    }

    public function edit_ajax(string $id)
    {
        $user = Users::find($id);
        $roles = ['admin', 'mahasiswa', 'dosen_pembimbing'];

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.user.edit_ajax', compact('user', 'roles'));
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'username' => 'required|max:50|unique:users,username,' . $id . ',id_user',
            'password' => 'nullable|min:6|max:100',
            'role'     => 'required|in:admin,mahasiswa,dosen_pembimbing',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors(),
            ], 422);
        }

        $user = Users::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        if ($user) {
            $data = [
                'username' => $request->username,
                'role'     => $request->role,
            ];

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diupdate',
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Data tidak ditemukan',
        ]);
    }

    public function show_ajax(string $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.user.show_ajax', compact('user'));
    }

    public function confirm_ajax(string $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return view('admin.user.confirm_ajax', compact('user'));
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
}
