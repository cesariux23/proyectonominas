<?php

use Illuminate\Database\Seeder;

use App\Adscripcion;

class AdscripcionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $adscripciones = [
        [
          'nombre' => 'Departamento de Recursos Humanos',
          'unidad' => '142',
          'subunidad' =>'03',
          'activa' => true
        ]
      ];

      foreach ($adscripciones as $adscripcion) {
        Adscripcion::firstOrCreate($adscripcion);
      }
    }
}
