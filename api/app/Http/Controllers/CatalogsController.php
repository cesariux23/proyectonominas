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
        $adscripciones = Adscripcion::all();
        $plazas = Plaza::all();
        $tipo_pago = [
            'CHEQUE' => 'CHEQUE',
            'DEPOSITO' => 'DEPOSITO BANCARIO'
        ];
        $bancos = ['BANAMEX', 'BANCOMER', 'HSBC'];

        $catalogs = [
            'tipo_contrato' => $tipo_contrato,
            'adscripciones' => $adscripciones,
            'plazas' => $plazas,
            'bancos' => $bancos,
            'tipo_pago' => $tipo_pago
        ];
        return response()->json($catalogs);
    }
}