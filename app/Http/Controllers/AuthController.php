<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $karyawan = Karyawan::where('employee_id', $request->employee_id)->first();

        if ($karyawan && Hash::check($request->password, $karyawan->password)) {
            session(['karyawan' => $karyawan]);

            if ($karyawan->employee_id === 'ADMIN') {
                return redirect('/admin/dashboard');
            }
            return redirect('/absensi');
        }

        return back()->with('error', 'ID atau password salah!');
    }

    public function logout()
    {
        session()->forget('karyawan');
        return redirect('/');
    }
}