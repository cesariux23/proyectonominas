<?php

namespace App\Http\Controllers;

use App\Adscripcion;
use App\Plaza;
use App\CatalogoNomina; 

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
        $tipo_contrato = ['BASE', 'CONFIANZA', 'HONORARIOS'];
        $status = [
            'ACTIVO' => [
                'ACTIVO',
                'COMISIONADO'
            ],
            'LICENCIA' => [
                'LICENCIA MEDICA',
                'LICENCIA SIN GOSE DE SUELDO',
            ],
            'BAJA' => [
                'BAJA POR PROMOCIÓN',
                'BAJA POR JUBILACIÓN',
                'BAJA POR RENUNCIA',
                'BAJA POR DESPIDO',
                'BAJA POR DEFUNCIÓN'

            ]
        ];
        $tipo_contrato = ['BASE', 'CONFIANZA', 'HONORARIOS'];
        $tipo_nombramiento = ['TEMPORAL', 'INTERINO', 'PROVISIONAL', 'DEFINITIVO'];
        $adscripciones = Adscripcion::all();
        $plazas = Plaza::all();
        $tipo_pago = [
            'CHEQUE' => 'CHEQUE',
            'DEPOSITO' => 'DEPOSITO BANCARIO'
        ];
        $bancos = ['BANAMEX', 'BANCOMER', 'HSBC'];

        $catalogo_nominas = CatalogoNomina::all();
        $periodicidad = [
            "QUINCENAL",
            "MENSUAL",
            "OTRO"
        ];

        $catalogos = [
            'tipo_contrato' => $tipo_contrato,
            'tipo_nombramiento' => $tipo_nombramiento,
            'status' => $status,
            'adscripciones' => $adscripciones,
            'plazas' => $plazas,
            'bancos' => $bancos,
            'tipo_pago' => $tipo_pago,
            'tipo_nomina' => $catalogo_nominas,
            'periodicidad' => $periodicidad
        ];
        return response()->json($catalogos);
    }
}