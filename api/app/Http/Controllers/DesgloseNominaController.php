<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesgloseNomina;

class DesgloseNominaController extends Controller
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

    public function index()
    {
        $empleado = DesgloseNomina::with('empleado')->get();
        return response()->json($empleado);
    }

    public function store(Request $request, $id_nomina)
    {
        $empleados = $request->empleados;
        $nomina = \App\Nomina::find($id_nomina);
        foreach ($empleados as $id) {
            $nuevo = [
                'nomina_id' => $id_nomina,
                'empleado_id' => $id
            ];
            $empleado = DesgloseNomina::firstOrCreate($nuevo);
            // Se toman los conceptos configurados en la nomina para crear el nuevo valor del desglose

            //Se calculan el desglose
            $empleado->calcula();
        }
        return response()->json($nomina);
    }

    //
    public function show($id_nomina, $id_desglose)
    {
        $empleado = DesgloseNomina::with('empleado')->find($id_desglose);
        if (!$empleado) {
            return response()->json(['error' => 'No se encontro el empleado con el ID especificado.'],404);
        }
        return response()->json($empleado);
    }
}