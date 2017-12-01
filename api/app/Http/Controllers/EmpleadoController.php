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
        if (!$empleado) {
            return response()->json(['error' => 'No se encontro el empleado.'],404);
        }
        return response()->json($empleado);
    }

    public function store(Request $request) {
        // se crea el empleado
        $empleado = new Empleado($request->except(['datos_personales', 'puesto_actual']));
        //Se crea el objeto relacionado con personal
        $empleado->personal_id = $this->actualizaDatosPersonales(collect($request->datos_personales));
        // Se almacena el empleado en la base de datos para poder registrar el puesto
        $empleado->save();
        try {
            //se inserta el puesto en la base de datos
            if ($request->input('puesto_actual') !== null) {
                $puesto = new Puesto($request->input('puesto_actual'));
                $puesto->empleado_id = $empleado->id;
                $puesto->save();
                //se vincula como puesto actual
                $empleado->puesto_id = $puesto->id;
                $empleado->save();
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 409);
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
        
        try {
            if ($request->input('datos_personales') != null) {
                //Actualizacion de datos personales
                $this->actualizaDatosPersonales(collect($request->datos_personales), $empleado->personal_id);
            }
            $empleado->update($request->except(['datos_personales', 'puesto_actual']));
        } catch (\Exception $e) {
            $error = (string)$e->getMessage();
            if(strpos($error, "Duplicate entry")) {
                $rfc = $request->datos_personales['rfc'];
                $error = "El RFC <b>{$rfc}</b> ya existe en la base de datos.";
            }
            return response()->json(['error' => $error], 409);
        }  
        return response()->json($empleado);
    }


    //funcion auxiliar que actualiza los datos personales del empleado
    public function actualizaDatosPersonales($datos, $id = false)
    {
        // convierte valores el mayusculas
        $datos_personales = $datos->map( function ($item, $key) {
            if (is_string($item)) {
                $item = strtoupper($item);
            }
            return $item;
        });
        //Se busca por id o rfc
        if ($id) {
            $personal = Personal::find($id);
        } else {
            $personal = Personal::firstOrCreate(['rfc' => $datos_personales->get('rfc')]);
        }
        //se actualizan los valores en la base de datos
        $personal->update($datos_personales->toArray());
        // se retorna el id para vincularlo con el empleado
        return $personal->id;
    }
}