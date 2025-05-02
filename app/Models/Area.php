<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['nombre'];

    public function especialistas()
    {
        return $this->hasMany(Especialista::class);
    }
}
