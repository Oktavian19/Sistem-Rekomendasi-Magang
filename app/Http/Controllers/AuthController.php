<?php

namespace App\Http\Controllers;

use App\Models\Users; // Menggunakan model User (standar Laravel)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

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
        return view('welcome');
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

        if (Auth::attempt($credentials)) {
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
                'message' => 'Username atau password salah'
            ], 401);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
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

        return view('auth.register');
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
            'username' => 'required|string|min:4|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,mahasiswa,dosen_pembimbing'
        ], [
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username minimal 4 karakter',
            'username.max' => 'Username maksimal 50 karakter',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid'
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        try {
            Users::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi berhasil, silakan login',
                    'redirect' => route('login')
                ]);
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
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