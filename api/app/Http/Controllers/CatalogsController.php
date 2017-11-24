<?php

namespace App\Http\Controllers;

use App\Adscripcion;

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
        $adscripciones = Adscripcion::all();
        $catalogs = [
            'adscripciones' => $adscripciones,
        ];
        return response()->json($catalogs);
    }
}