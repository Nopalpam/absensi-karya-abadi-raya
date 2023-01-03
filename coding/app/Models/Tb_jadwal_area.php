<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_jadwal_area extends Model
{
    use HasFactory;

    protected $table = 'tb_jadwal_area';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function area()
    {
        return $this->hasOne(Area::class, 'id', 'id_area');
    }
}
