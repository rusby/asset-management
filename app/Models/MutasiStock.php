<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_barang',
        'id_event',
        'status_mutasi',
    ];
}
