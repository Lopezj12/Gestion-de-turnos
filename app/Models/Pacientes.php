<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    use HasFactory;

    protected $fillable = ['cedula', 'nombre', 'telefono'];

    public function turnos()
    {
        return $this->hasMany(turnos::class);
    }
}
