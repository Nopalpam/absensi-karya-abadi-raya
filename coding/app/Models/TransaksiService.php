<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiService extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi_service';
    protected $primaryKey = 'id_transaksi_service';
    protected $guarded = [];

    public function jpekerjaan()
    {
        return $this->hasMany(JenisPekerjaan::class, 'id_jenis_pekerjaan', 'jenis_pekerjaan');
    }
}
