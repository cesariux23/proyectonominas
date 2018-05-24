<?php

use Illuminate\Database\Seeder;
use App\Plaza;

class PlazasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $plazas = [
        [
          'nombre' => 'Especialista en proyectos técnicos',
          'clave' => '142',
          'zona' => 1,
          'tipo' => 'BASE',
          'autorizadas' => 2
        ]
      ];

      foreach ($plazas as $plaza) {
        Plaza::firstOrCreate($plaza);
      }
    }
}
