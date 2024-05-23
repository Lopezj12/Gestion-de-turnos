<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacientes;

class PacientesController extends Controller
{
    public function index()
    {
        return Pacientes::all();
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
        ]);

        $paciente = Pacientes::create($request->all());

        return response()->json($paciente, 201);
    }

    public function mirar($id)
    {
        return Pacientes::findOrFail($id);
    }

    public function actualizar(Request $request, $id)
    {
        $paciente = Pacientes::findOrFail($id);

        $request->validate([
            'cedula' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
        ]);

        $paciente->update($request->all());

        return response()->json($paciente, 200);
    }

    public function eliminar($id)
    {
        Pacientes::destroy($id);

        return response()->json(null, 204);
    }
}
