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

    // almacena la nomina
    public function store(Request $request)
    {
        $empleado = DesgloseNomina::create($request->all());
        return response()->json($empleado);
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