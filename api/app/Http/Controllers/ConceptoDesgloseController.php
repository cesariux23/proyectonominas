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

        //se actualiza las sumas del desglose
        $concepto->desglose->calcula();
        
        return response()->json($concepto);
    }


    public function update(Request $request, $id)
    {
        $concepto = ConceptoDesglose::find($id);
        $concepto->update($request->except(['id']));

        //se actualiza las sumas del desglose
        $concepto->desglose->calcula();

        return response()->json($concepto);
    }

    public function destroy(Request $request, $id)
    {
        $concepto = ConceptoDesglose::find($id);
        $desglose = $concepto->desglose;

        $concepto->delete();
        //se actualiza las sumas del desglose
        $desglose->calcula();

        return response()->json($concepto);
    }

    // funcion para buscar los valores de los conceptos en la nomina
    public function findByName(Type $var = null)
    {
        # code...
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