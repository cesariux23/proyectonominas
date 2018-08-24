<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConceptoDesglose;

class ConceptoDesgloseController extends Controller
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
    /*
    public function index()
    {
        $empleado = ConceptoDesglose::with('empleado')->get();
        return response()->json($empleado);
    }*/

    // almacena el concepto
    public function store(Request $request)
    {
        $concepto = ConceptoDesglose::create($request->all());
        return response()->json($concepto);
    }


    public function update(Request $request, $id)
    {
        $concepto = ConceptoDesglose::find($id);
        $concepto->update($request->except(['id']));
        return response()->json($concepto);
    }

    public function destroy(Request $request, $id)
    {
        $concepto = ConceptoDesglose::find($id);
        $concepto->delete();
        return response()->json($concepto);
    }

    /*
    //
    public function show($id_nomina, $id_desglose)
    {
        $empleado = ConceptoDesglose::with('empleado')->find($id_desglose);
        if (!$empleado) {
            return response()->json(['error' => 'No se encontro el empleado con el ID especificado.'],404);
        }
        return response()->json($empleado);
    }
    */
}