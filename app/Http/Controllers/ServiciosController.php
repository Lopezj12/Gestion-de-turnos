<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicios;

class ServiciosController extends Controller
{
    public function index()
    {
        return Servicios::all();
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $servicio = Servicios::create($request->all());

        return response()->json($service, 201);
    }

    public function mirar($id)
    {
        return Servicios::findOrFail($id);
    }

    public function actualizar(Request $request, $id)
    {
        $servicio = Servicios::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $servicio->update($request->all());

        return response()->json($servicio, 200);
    }

    public function eliminar($id)
    {
        Servicios::destroy($id);

        return response()->json(null, 204);
    }
}
