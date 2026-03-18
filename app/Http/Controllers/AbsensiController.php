<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        if (!session('karyawan')) return redirect('/');
        
        $karyawan = session('karyawan');
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', Carbon::today())
            ->first();

        return view('absensi', compact('karyawan', 'absensiHariIni'));
    }

    public function absenMasuk(Request $request)
    {
        if (!session('karyawan')) return redirect('/');
        
        $karyawan = session('karyawan');
        
        // Simpan foto
        $fotoPath = null;
        if ($request->foto) {
            $foto = $request->foto;
            $foto = str_replace('data:image/jpeg;base64,', '', $foto);
            $foto = str_replace(' ', '+', $foto);
            $fotoName = 'foto_' . $karyawan->id . '_' . time() . '.jpg';
            file_put_contents(public_path('foto/' . $fotoName), base64_decode($foto));
            $fotoPath = $fotoName;
        }

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal'     => Carbon::today(),
            'jam_masuk'   => Carbon::now()->format('H:i:s'),
            'foto_masuk'  => $fotoPath,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => 'hadir',
        ]);

        return response()->json(['success' => true, 'waktu' => Carbon::now()->format('H:i:s')]);
    }

    public function absenPulang(Request $request)
    {
        if (!session('karyawan')) return redirect('/');
        
        $karyawan = session('karyawan');
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', Carbon::today())
            ->first();

        if ($absensi) {
            $absensi->update(['jam_pulang' => Carbon::now()->format('H:i:s')]);
        }

        return response()->json(['success' => true, 'waktu' => Carbon::now()->format('H:i:s')]);
    }

    public function riwayat()
    {
        if (!session('karyawan')) return redirect('/');
        
        $karyawan = session('karyawan');
        $riwayat = Absensi::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->take(30)
            ->get();

        return response()->json($riwayat);
    }
}