<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sik_Karyawan extends Model
{
    use HasFactory;
    protected $table = 'sik_karyawan';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_karyawan');
    }
}
