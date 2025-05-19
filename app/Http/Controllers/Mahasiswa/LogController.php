<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogKegiatan;

class LogController extends Controller
{
    public function index()
    {
        return view('mahasiswa.log.index');
    }

    public function create()
    {
        return view('mahasiswa.log.create');
    }

    public function store(Request $request)
    {
        // Implement the logic to store the log entry
    }

    public function edit()
    {
        return view('mahasiswa.log.edit');
    }

    public function confirm_delete()
    {
        return view('mahasiswa.log.confirm');
    }
}
