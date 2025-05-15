<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        // Jika sudah login, redirect berdasarkan role
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'mahasiswa') {
                return redirect('/dashboard-mahasiswa');
            }

            return redirect('/dashboard'); // default untuk role lain
        }

        return view('auth.login');
    }


    public function landing_page()
    {
        return view('welcome');
    }

    public function postlogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Menentukan URL redirect berdasarkan role
            if ($user->role === 'mahasiswa') {
                $redirectUrl = url('/dashboard-mahasiswa');
            } else {
                $redirectUrl = url('/dashboard'); // default untuk role lain
            }

            // Jika request dari AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => $redirectUrl
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        // Jika login gagal
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register()
    {
        // Jika sudah login, redirect ke halaman home
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.register');
    }

    public function postregister(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:4|max:50|unique:users,username',
                'password' => 'required|string|min:6',
                'role' => 'required|in:admin,mahasiswa,dosen_pembimbing'
            ], [
                // Custom error messages
                'username.required' => 'Username harus diisi',
                'username.min' => 'Username minimal 4 karakter',
                'username.max' => 'Username maksimal 50 karakter',
                'username.unique' => 'Username sudah digunakan',

                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter',

                'role.required' => 'Role harus dipilih',
                'role.in' => 'Role tidak valid'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                Users::create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => $request->role
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi berhasil, silakan login',
                    'redirect' => url('login')
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('register');
    }
}
