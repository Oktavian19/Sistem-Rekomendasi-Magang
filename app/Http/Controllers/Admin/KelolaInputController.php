<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{BidangKeahlian};
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KelolaInputController extends Controller
{
    public function input_fasilitas()
    {
        return view('admin.input_fasilitas.index');
    }

    public function input_bidang_keahlian()
    {
        return view('admin.input_bidang_keahlian.index');
    }
}