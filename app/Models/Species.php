<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;

    public function limbo_data()
    {
        return $this->belongsTo(LimboData::class);
    }

    public function taxa()
    {
        return $this->belongsTo(Taxa::class);
    }
}
