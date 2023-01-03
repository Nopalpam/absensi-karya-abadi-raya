<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');
        if (auth()->user()->level == 'admin') {
            return view('admin.dashboard', compact('tanggal_awal', 'tanggal_akhir'));
        } else {
            return view('karyawan.dashboard');
        }
    }

    public function absensi()
    {
        return view('karyawan.absensi');
    }
}
