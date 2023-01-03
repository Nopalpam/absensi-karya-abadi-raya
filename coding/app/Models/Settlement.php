<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $table = 'tb_settlement';
    protected $primaryKey = 'id_settlement';
    protected $guarded = [];

    // public function jpekerjaan()
    // {
    //     return $this->hasMany(JenisPekerjaan::class, 'id_jenis_pekerjaan', 'jenis_pekerjaan');
    // }
}
