<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table = "izin";
    protected $primaryKey = "id";

    protected $fillable = [
        'nik',
        'tgl_mulai',
        'tgl_selesai',
        'jml_hari',
        'status',
        'bukti_sakit',
        'keterangan',
        'approve'
    ];
}
