<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{
    protected $table = 'karyawan';
    protected $fillable = ['nama', 'jabatan', 'employee_id', 'password'];
    protected $hidden = ['password'];
}