<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\Personal;
use App\Puesto;
use App\Status;
use DateTime;
use DateInterval;

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
    public function index(Request $request){
        $query  = Empleado::with(
            'datos_personales',
            'status',
            'puesto_actual',
            'puesto_actual.adscripcion',
            'puesto_actual.plaza'
        );
        
        //filtros
        if ($request->has('rfc')) {
            $query->rfc($request->rfc);
        }
        if ($request->has('status')) {
            $query->status($request->status);
        }
        if ($request->has('tipo_contrato')) {
            $query->tipoContrato($request->tipo_contrato);
        }
        $empleados = $query->get();
        return response()->json($empleados);
    }

    public function show($id){
        $empleado  = Empleado::with(
            'datos_personales',
            'puesto_actual',
            'status',
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
            // Se genera el status inicial
            $status = [
                'status' => 'ACTIVO',
                'observaciones'=>'ALTA EN EL SISTEMA',
                'fecha_inicio' => $puesto->fecha_inicio
            ];
            self::almacenaEstatus($empleado, $status);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 409);
        }
        
        $empleado->load(
            'datos_personales',
            'status',
            'puesto_actual',
            'puesto_actual.adscripcion',
            'puesto_actual.plaza',
            'historial.adscripcion'
        );
        return response()->json($empleado);
    }

    public function update(Request $request, $id){
        $empleado = Empleado::find($id);
        $status = $request->input('status');

        // datos personales
        if ($request->input('datos_personales') != null) {
            try {
            
                //Actualizacion de datos personales
                $this->actualizaDatosPersonales(collect($request->datos_personales), $empleado->personal_id);
            } catch (\Exception $e) {
                $error = (string)$e->getMessage();
                if(strpos($error, "Duplicate entry")) {
                    $rfc = $request->datos_personales['rfc'];
                    $error = "El RFC <b>{$rfc}</b> ya existe en la base de datos.";
                }
                return response()->json(['error' => $error], 409);
            }
        }

        // datos del puesto actual
        if ($request->input('puesto_actual') != null) {
            $this->actualizaDatosPuestoActual(collect($request->puesto_actual), $empleado->puesto_id);
            // Se genera el status inicial
            $status = [
                'status' => 'ACTIVO',
                'observaciones'=>'CAMBIO DE PUESTO',
                'fecha_inicio' => $request->input('puesto_actual')['fecha_inicio']
            ];
        }
        // actualiza status
        if ($status != null) {
            if ($empleado->status->fecha_fin == null){
                //el estatus anterior finaliza al iniciar el nuevo
                //$fecha_fin = date($request->input('status')['fecha_inicio']);
                $fecha_fin = new DateTime($status['fecha_inicio']);
                $fecha_fin = $fecha_fin->sub(new DateInterval('P1D'));
                $empleado->status->update(['fecha_fin' => $fecha_fin]);
            }
            $this->almacenaEstatus($empleado, $status);
        }

        //si se da de baja, tambien se marca como finalizado el puesto actual
        if ($request->input('fecha_baja') != null) {
            $empleado->puesto_actual->update(['fecha_fin' => $request->input('fecha_baja')]);
        }

        // se actualizan los campos de empleado
        $empleado->update($request->except(['datos_personales', 'puesto_actual', 'status']));
        $empleado->load(
            'datos_personales',
            'status',
            'puesto_actual',
            'puesto_actual.adscripcion',
            'puesto_actual.plaza',
            'historial.adscripcion'
        );
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

    //funcion auxiliar que actualiza los datos del puesto
    public function actualizaDatosPuestoActual($datos, $id = false)
    {
        // convierte valores el mayusculas
        $datos_puesto = $datos->map( function ($item, $key) {
            if (is_string($item)) {
                $item = strtoupper($item);
            }
            return $item;
        });
        $puesto = Puesto::find($id);
        //se actualizan los valores en la base de datos
        $puesto->update($datos_puesto->toArray());
    }

    //funcion auxiliar para almacenar y vincular los cambios de estatus
    public function almacenaEstatus($empleado, $status)
    {
        $status['empleado_id'] = $empleado->id;
        $status['personal_id'] = $empleado->personal_id;
        $status_obj = Status::firstOrCreate($status);
        $empleado->status_id = $status_obj->id;
        $empleado->save();
    }
}