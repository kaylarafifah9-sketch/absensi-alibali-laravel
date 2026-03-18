<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        if (!session('karyawan')) return redirect('/');
        
        $karyawan = session('karyawan');
        if ($karyawan->employee_id !== 'ADMIN') return redirect('/absensi');

        $totalKaryawan = Karyawan::where('employee_id', '!=', 'ADMIN')->count();
        
        $hadirHariIni = Absensi::where('tanggal', Carbon::today())
            ->distinct('karyawan_id')
            ->count();

        $belumAbsen = $totalKaryawan - $hadirHariIni;

        $logAbsensi = Absensi::with('karyawan')
            ->where('tanggal', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        $semuaKaryawan = Karyawan::where('employee_id', '!=', 'ADMIN')->get();

        return view('admin.dashboard', compact(
            'totalKaryawan', 'hadirHariIni', 
            'belumAbsen', 'logAbsensi', 'semuaKaryawan'
        ));
    }
}