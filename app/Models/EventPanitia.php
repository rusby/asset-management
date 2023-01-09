<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPanitia extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_event',
        'id_user',
    ];
}
