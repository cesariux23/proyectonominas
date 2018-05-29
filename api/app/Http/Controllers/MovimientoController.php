<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\Puesto;

class MovimientoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // almacena los nuevos movimientos, y da de baja el puesto actual
    public function store(Request $request, $id)
    {
        $empleado = Empleado::find($id);
        $puesto = Puesto::firstOrCreate($request->puesto);
        // si se envia la fecha de fin del puesto se da de baja el puesto actual y se actualiza el empleado
        if ($request->input('fecha_fin') != null) {
            if ($puesto->id != $empleado->puesto_id) {
                $empleado->puesto_actual->update(['fecha_fin' => $request->fecha_fin]);
                $empleado->update(['puesto_id' => $puesto->id]);
            } else {
                return response()->json(['error' => 'Sin cambios que registrar.'], 409);
            }
        }
        return response()->json($puesto);
    }
}
