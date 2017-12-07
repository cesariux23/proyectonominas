<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nomina;

class NominaController extends Controller
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
        $nominas = Nomina::with('tipoNomina')->get();
        return response()->json($nominas);
    }

    // almacena la nomina
    public function store(Request $request)
    {
        $nomina = Nomina::create($request->all());
        return response()->json($nomina);
    }

    //
    public function show($id)
    {
        $nomina = Nomina::with('tipoNomina')->find($id);
        if (!$nomina) {
            return response()->json(['error' => 'No se encontro el proceso de nomina con el ID especificado.'],404);
        }
        return response()->json($nomina);
    }
}
