<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('karyawan')->insert([
            ['nama' => 'Ellan', 'jabatan' => 'Karyawan',
             'employee_id' => 'EMP001', 'password' => Hash::make('1234'),
             'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Aldy', 'jabatan' => 'Karyawan',
             'employee_id' => 'EMP002', 'password' => Hash::make('1243'),
             'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Rossa', 'jabatan' => 'Karyawan',
             'employee_id' => 'EMP003', 'password' => Hash::make('1212'),
             'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Manager HRD', 'jabatan' => 'Administrator',
             'employee_id' => 'ADMIN', 'password' => Hash::make('admin'),
             'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}