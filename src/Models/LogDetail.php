<?php

namespace Rras3k\Sebconsole\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDetail extends Model
{
    use HasFactory;

    public function add($message){
        $this->texte = $message;
        $this->user_id = Auth::user()->id;
    }
}
