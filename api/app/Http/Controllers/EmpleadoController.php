<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\Personal;
use App\Puesto;

class EmpleadoController extends Controller
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
    public function index(){
        $empleados  = Empleado::with(
            'datos_personales',
            'puesto_actual',
            'puesto_actual.adscripcion',
            'puesto_actual.plaza',
            'historial.adscripcion'
        )->get();
        return response()->json($empleados);
    }

    public function show($id){
        $empleado  = Empleado::with(
            'datos_personales',
            'puesto_actual',
            'historial',
            'puesto_actual.adscripcion',
            'puesto_actual.plaza',
            'historial.adscripcion',
            'historial.plaza'
        )->find($id);
        return response()->json($empleado);
    }

    public function store(Request $request){

        $empleado = new Empleado($request->all());

        //Se crea el objeto relacionado con personal
        if ($request->input('personal_id') === null) {
            $personal = Personal::firstOrCreate($request->input('datos_personales'));
            $empleado->personal_id = $personal->id;
        } else {
            $personal = Personal::find($request->input('personal_id'));
            $personal->update($request->input('datos_personales'));
        }
        $empleado->save();

        //se inserta el puesto en la base de datos
        if ($request->input('puesto_actual') !== null) {
            $puesto = new Puesto($request->input('puesto_actual'));
            $puesto->empleado_id = $empleado->id;
            $puesto->save();
            $empleado->puesto_id = $puesto->id;
            $empleado->save();
        }
        
        $empleado->load(
            'datos_personales',
            'puesto_actual',
            'puesto_actual.adscripcion',
            'puesto_actual.plaza',
            'historial.adscripcion'
        );
        return response()->json($empleado);
    }

    public function update(Request $request, $id){
        
                $empleado = Empleado::with(
                    'datos_personales',
                    'puesto_actual',
                    'historial',
                    'puesto_actual.adscripcion',
                    'puesto_actual.plaza',
                    'historial.adscripcion'
                )->find($id);
                $empleado->update($request->all());
                return response()->json($empleado);
            }
}