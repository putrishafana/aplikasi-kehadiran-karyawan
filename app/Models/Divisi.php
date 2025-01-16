<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $table = "divisi";
    protected $primaryKey = "kd_divisi";

    protected $fillable = [
        'kd_divisi',
        'nm_divisi',
    ];
}
