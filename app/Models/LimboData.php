<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimboData extends Model
{
    use HasFactory;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function taxa()
    {
        return $this->hasMany(Taxa::class);
    }

    public function species()
    {
        return $this->hasMany(Species::class);
    }
}
