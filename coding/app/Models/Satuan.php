<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'satuan';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function base_unit()
    {
        return $this->belongsTo(Satuan::class, 'base_unit_id');
    }
}
