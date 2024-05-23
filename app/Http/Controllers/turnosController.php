<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\turnos;
use Illuminate\Support\Facades\Log;

class turnosController extends Controller
{
    public function index()
    {
        return turnos::with('servicio', 'paciente')->get();
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id',
            'id_servicio' => 'required|exists:servicios,id',
            'hora_asignacion' => 'required|date',
            'estado' => 'required|in:Pendiente,Completado,Cancelado',
        ]);

            $turno = turnos::create($request->all());

            return response()->json($turno, 201);

    }

    public function mirar($id)
    {
        return turnos::with('servicio', 'paciente')->findOrFail($id);
    }

    public function actualizar(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'estado' => 'required|in:Pendiente,Completado,Cancelado',
        ]);


        try {
            // Obtener el turno
            $turno = turnos::findOrFail($id);

            // Actualizar el estado del turno
            $turno->estado = $request->estado;
            $turno->save();

            return response()->json($turno, 200);
        } catch (\Exception $e) {
            // Manejar cualquier excepción y devolver un mensaje de error
            return response()->json(['error' => 'Error al actualizar el estado del turno: ' . $e->getMessage()], 422);
        }
    }
    public function eliminar($id)
    {
        turnos::destroy($id);

        return response()->json(null, 204);
    }
}
