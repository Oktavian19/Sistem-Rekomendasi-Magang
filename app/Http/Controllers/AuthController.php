<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\Users; // Menggunakan model User (standar Laravel)
use App\Models\ProgramStudi;
use App\Models\OpsiPreferensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        return view('auth.login');
    }

    /**
     * Menampilkan halaman landing page
     *
     * @return \Illuminate\View\View
     */
    public function landingPage()
    {
        $lowongans = Lowongan::with('perusahaan')
            ->orderBy('id_lowongan', 'desc')
            ->take(9)
            ->get();

        $bidangKeahlian = OpsiPreferensi::where('id_kategori', 5)->take(8)->get();

        $availableImages = [
            'https://diploy.id/get-file?path=job-field%2Fd3d019d1-8bbe-47ff-b8c8-9ead895744c1.png',
            'https://diploy.id/get-file?path=job-field%2Fdd44f13e-51df-4d33-9f2f-b389e9d91cd4.png',
            'https://diploy.id/get-file?path=job-field%2F6531cc18-faa3-457e-b18a-5458b410da80.png',
            'https://diploy.id/get-file?path=job-field%2F2ddedfde-5022-4d8d-97ce-030d4a163abf.png',
            'https://diploy.id/get-file?path=job-field%2Fd2e0eae8-0a6b-4e63-b3a4-dfcb607e38db.png',
            'https://diploy.id/get-file?path=job-field%2F4b0813f1-167c-41c6-bbd0-59f1ad735f8d.png',
            'https://diploy.id/get-file?path=job-field%2F64f29e9a-269c-4ac4-a4c0-941c3c507ae7.png',
            'https://diploy.id/get-file?path=job-field%2Fddaa98d8-5bfe-42c3-bd5a-f90f79704288.png'
        ];

        shuffle($availableImages);

        $bidangGambar = [];
        
        foreach ($bidangKeahlian as $index => $bidang) {
            $bidangGambar[$bidang->id] = $availableImages[$index % count($availableImages)] ?? 'sneat/assets/img/1.png';
        }

        return view('welcome', compact('lowongans', 'bidangKeahlian', 'bidangGambar'));
    }

    /**
     * Proses login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Tambah pengecekan status aktif
        if (Auth::attempt(array_merge($credentials, ['status' => 'aktif']))) {
            $request->session()->regenerate();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'redirect' => $this->getDashboardUrl()
                ]);
            }

            return redirect()->intended($this->getDashboardUrl());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password salah atau akun tidak aktif'
            ], 401);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah atau akun tidak aktif.',
        ])->onlyInput('username');
    }


    /**
     * Proses logout
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Menampilkan halaman registrasi
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function register()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $programStudi = ProgramStudi::all(); // ambil semua data prodi

        return view('auth.register',  compact('programStudi'));
    }

    /**
     * Proses registrasi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|min:8|max:20|unique:users,username',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:mahasiswa,email',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'id_program_studi' => 'required|exists:program_studi,id_program_studi',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nim.required' => 'NIM harus diisi',
            'nim.unique' => 'NIM sudah digunakan sebagai username',
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'alamat.required' => 'Alamat harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'id_program_studi.required' => 'Program studi harus dipilih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Tambahkan user
            $user = Users::create([
                'username' => $request->nim,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa'
            ]);

            // Tambahkan mahasiswa dengan relasi ke user
            Mahasiswa::create([
                'id_mahasiswa' => $user->id_user, // sesuaikan primary key user
                'nim' => $request->nim,
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'id_program_studi' => $request->id_program_studi,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Registrasi mahasiswa berhasil',
                'redirect' => route('login')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Redirect ke dashboard berdasarkan role user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToDashboard()
    {
        return redirect($this->getDashboardUrl());
    }

    /**
     * Mendapatkan URL dashboard berdasarkan role user
     *
     * @return string
     */
    protected function getDashboardUrl()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'mahasiswa':
                return '/dashboard-mahasiswa';
            case 'dosen_pembimbing':
                return '/dashboard-dosen';
            case 'admin':
                return '/dashboard-admin';
            default:
                return '/dashboard';
        }
    }
}
