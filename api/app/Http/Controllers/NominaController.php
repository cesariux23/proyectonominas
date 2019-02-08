<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nomina;
use App\PlantillaNomina;
use App\ProcesoNomina;

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
        $nomina = Nomina::create($request->except(['configuracion', 'conceptos']));
        // Se almacena la configuración en la DB
        foreach ($request->configuracion as $k => $v) {
          $config = [
            'tipo' => 'CONFIGURACION',
            'nomina_id' => $nomina->id,
            'clave' => $k,
            'valor' => $v
          ];
          \App\ConfiguracionNomina::create($config);
        }
        foreach ($request->conceptos as $k => $v) {
          $con = [
            'tipo' => 'CONCEPTO',
            'nomina_id' => $nomina->id,
            'clave' => $k,
            'valor' => $v
          ];
          \App\ConfiguracionNomina::create($con);
        }

        // se busca la configuracion del proceso para generar el desglose
        return response()->json($nomina);
    }

    //
    public function show($id)
    {
        $nomina = Nomina::with('tipoNomina', 'desglose', 'desglose.empleado')->find($id);
        if (!$nomina) {
            return response()->json(['error' => 'No se encontro el proceso de nomina con el ID especificado.'],404);
        }
        return response()->json($nomina);
    }
}
