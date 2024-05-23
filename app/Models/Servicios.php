<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function turnos()
    {
        return $this->hasMany(turnos::class);
    }
}
