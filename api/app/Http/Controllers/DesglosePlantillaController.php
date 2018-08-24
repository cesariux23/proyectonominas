<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesglosePlantilla;

class DesglosePlantillaController extends Controller
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
        $empleado = DesglosePlantilla::with('empleado')->get();
        return response()->json($empleado);
    }

    // almacena la nomina
    public function store(Request $request)
    {
        $empleado = DesglosePlantilla::create($request->all());
        return response()->json($empleado);
    }

    //
    public function show($id_nomina, $id_desglose)
    {
        $empleado = DesglosePlantilla::with('empleado')->find($id_desglose);
        if (!$empleado) {
            return response()->json(['error' => 'No se encontro el empleado con el ID especificado.'],404);
        }
        return response()->json($empleado);
    }
}