<?php

namespace App\Http\Controllers;

use App\Adscripcion;
use App\Plaza;

class CatalogsController extends Controller
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
                'BAJA POR JUBILACIÓN',
                'BAJA POR RENUNCIA',
                'BAJA POR DESPIDO',
                'BAJA POR DEFUNCIÓN'

            ]
        ];
        $tipo_contrato = ['BASE', 'CONFIANZA', 'HONORARIOS'];
        $adscripciones = Adscripcion::all();
        $plazas = Plaza::all();
        $tipo_pago = [
            'CHEQUE' => 'CHEQUE',
            'DEPOSITO' => 'DEPOSITO BANCARIO'
        ];
        $bancos = ['BANAMEX', 'BANCOMER', 'HSBC'];

        $catalogs = [
            'tipo_contrato' => $tipo_contrato,
            'status' => $status,
            'adscripciones' => $adscripciones,
            'plazas' => $plazas,
            'bancos' => $bancos,
            'tipo_pago' => $tipo_pago
        ];
        return response()->json($catalogs);
    }
}