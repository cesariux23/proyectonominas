<?php

use Illuminate\Database\Seeder;

use App\CatalogoNomina;

class CatalogoNominaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nominas = [
            [
                'descripcion' => 'NOMINA DE PERSONAL SINDICALIZADO',
                'tipo_empleado' => 'BASE'
            ],
            [
                'descripcion' => 'NOMINA DE PERSONAL DE CONFIANZA',
                'tipo_empleado' => 'CONFIANZA'
            ],
            [
                'descripcion' => 'NOMINA DE HONORARIOS',
                'tipo_empleado' => 'HONORARIOS'
            ],
        ];
        
        foreach ($nominas as $nomina) {
            CatalogoNomina::firstOrCreate($nomina);
          }
    }
}
