<?php

namespace Rras3k\Console\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogType extends Model
{
    use HasFactory;
    public static function liste()
    {
        return LogType::get();
    }
}
