<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHisto extends Model
{
    use HasFactory;

    public static function fetchLogs()
    {
        return self::orderBy('id', 'desc')->paginate(10);
    }
}
