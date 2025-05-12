<?php

namespace App\Http\Controllers;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:users,username',
            'password' => 'required|min:5',
            'role'     => 'required|in:admin,mahasiswa,dosen_pembimbing'
        ]);

        Users::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => $request->role
        ]);


        return redirect('/admin/user')->with('success', 'Data user berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        $user = Users::find($users->id_user);
        return view('admin.user.show', compact('user'));
    }

    public function edit(Users $users)
    {
        $user = Users::find($users->id_user);
        return view('admin.user.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:users,username,' . $users->id_user . ',id_user',
            'password' => 'nullable|min:5',
            'role'     => 'required|in:admin,mahasiswa,dosen_pembimbing'
        ]);

        Users::find($users->id_user)->update([
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : Users::find($users->id_user)->password,
            'role'     => $request->role
        ]);


        return redirect('/admin/user')->with('success', 'Data user berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        // Mengecek apakah data user dengan ID yang dimaksud ada atau tidak
        $check = Users::find($users->id_user);
        if (!$check) {
            return redirect('/admin/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            // Hapus data user
            Users::destroy($users->id_user);

            return redirect('/admin/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error saat menghapus, redirect dengan pesan error
            return redirect('/admin/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $roles = ['admin', 'mahasiswa', 'dosen_pembimbing'];
        return view('admin.user.create_ajax', compact('roles'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
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
                ]);
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

        return redirect('/admin/user');
    }

    public function edit_ajax(string $id)
    {
        $user = Users::find($id);
        $roles = ['admin', 'mahasiswa', 'dosen_pembimbing'];

        return view('admin.user.edit_ajax', compact('user', 'roles'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
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
                ]);
            }

            $user = Users::find($id);

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

        return redirect('/admin/user');
    }

    public function show_ajax(string $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return view('admin.user.show_ajax', compact('user'));
    }

    public function confirm_ajax(string $id)
    {
        $user = Users::find($id);
        return view('admin.user.confirm_ajax', compact('user'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = Users::find($id);

            if ($user) {
                $user->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return redirect('/admin/user');
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
