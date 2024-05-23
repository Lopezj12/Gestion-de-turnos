<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class turnos extends Model
{
    protected $table = 'turnos';

    public $timestamps = false;

    protected $fillable = ['id_paciente', 'id_servicio', 'hora_asignacion', 'estado'];

    public function servicio()
    {
        return $this->belongsTo(Servicios::class,'id_servicio');
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class,'id_paciente');
    }
}
