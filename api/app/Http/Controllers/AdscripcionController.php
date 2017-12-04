<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adscripcion;

class AdscripcionController extends Controller
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
    public function store(Request $request)
    {
        $adscripcion = Adscripcion::create($request->all());
        return response()->json($adscripcion);
    }

    
    public function update(Request $request, $id)
    {
        $adscripcion = Adscripcion::find($id);
        $adscripcion->update($request->all());
        return response()->json($adscripcion);
    }
}
