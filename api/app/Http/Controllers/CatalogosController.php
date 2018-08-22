<?php

namespace App\Http\Controllers;

use App\Adscripcion;
use App\Plaza;
use App\CatalogoNomina;
use App\CatalogoConcepto;

class CatalogosController extends Controller
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

    //
    public function index()
    {
        $status = [
            'ACTIVO' =>[
                'required' => ['fecha_inicio']
            ],
            'LICENCIA MEDICA' =>[
                'substatus' => [
                    'CON SUELDO BASICO INTEGRO',
                    'CON SUELDO BASICO AL 50%',
                    'CON SUELDO BASICO AL 25%',
                    'SIN SUELDO BASICO',
                ],
                'required' => ['fecha_inicio'],
                'optional' => ['fecha_fin']
            ],
            'LICENCIA LABORAL' => [
                'substatus' => [
                    'SIN GOSE DE SUELDO',
                    'CON GOSE DE SUELDO'
                ],
                'required' => ['fecha_inicio'],
                'optional' => ['fecha_fin']
            ],
            'BAJA' => [
                'substatus' => [
                    'POR PROMOCIÓN',
                    'POR RENUNCIA',
                    'DEFINITIVA POR JUBILACIÓN',
                    'DEFINITIVA POR DESPIDO',
                    'DEFINITIVA POR DEFUNCIÓN'
                ],
                'required' => ['fecha_baja']
            ]
        ];
        $tipo_contrato = ['BASE', 'CONFIANZA', 'HONORARIOS'];
        $tipo_nombramiento = ['TEMPORAL', 'INTERINO', 'PROVISIONAL', 'DEFINITIVO'];
        $adscripciones = Adscripcion::all();
        $plazas = Plaza::all();
        $tipo_pago = [
            'CHEQUE' => 'CHEQUE',
            'TRANSFERENCIA ELECTRÓNICA' => 'TRANSFERENCIA'
        ];
        $bancos = ['BANAMEX', 'BANCOMER', 'HSBC'];

        $catalogo_nominas = CatalogoNomina::all();
        $periodicidad = [
            "QUINCENAL",
            "MENSUAL",
            "ANUAL",
            "OTRO"
        ];

        $emision = [
            "ORDINARIA",
            "COMPLEMENTARIA",
            "EXTRAORDINARIA",
            "INCREMENTO",
            "OTRO"
        ];
        
        $percepciones = CatalogoConcepto::where('tipo', 'PERCEPCION')->get();
        $deducciones = CatalogoConcepto::where('tipo', 'DEDUCCION')->get();

        $catalogos = [
            'tipo_contrato' => $tipo_contrato,
            'tipo_nombramiento' => $tipo_nombramiento,
            'status' => $status,
            'adscripciones' => $adscripciones,
            'plazas' => $plazas,
            'bancos' => $bancos,
            'tipo_pago' => $tipo_pago,
            'tipo_nomina' => $catalogo_nominas,
            'periodicidad' => $periodicidad,
            'emision' => $emision,
            'percepciones' => $percepciones,
            'deducciones' => $deducciones,
        ];
        return response()->json($catalogos);
    }
}
