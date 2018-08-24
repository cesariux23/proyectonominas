<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Nomina;
use App\PlantillaNomina;
use App\ProcesoNomina;

class ProcesoNominaController extends Controller
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
        return ProcesoNomina::all();
    }

     // almacena la nomina
     public function store(Request $request)
     {
         $nomina = Nomina::create($request->all());
         // se asocia con una plantilla dentro del proceso de nomina
         if ($nomina->tipo_emision == 'ORDINARIA') {
             $plantilla = PlantillaNomina::firstOrCreate(['tipo_nomina_id' => $nomina->tipo_nomina_id,
                 'tipo_emision' => $nomina->tipo_emision,
                 'periodicidad' => $nomina->periodicidad
             ]);
         } else {
             $plantilla = Plantillanomina::create(['tipo_nomina_id' => $nomina->tipo_nomina_id]);
         }
 
         // se crea el proceso correspondiente
         $proceso = ProcesoNomina::create([
             'nomina_id' => $nomina->id,
             'plantilla_nomina_id' => $plantilla->id
         ]);
 
         return response()->json($proceso);
     }

    //
    public function show($id)
    {
        $nomina = ProcesoNomina::with('plantilla', 'plantilla.desglose')->find($id);
        if (!$nomina) {
            return response()->json(['error' => 'No se encontro el proceso de nomina con el ID especificado.'],404);
        }
        return response()->json($nomina);
    }
}
