<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('TestUserSeeder');
        $this->call('AdscripcionesSeeder');
        $this->call('PlazasSeeder');
        $this->call('ConceptoSeeder');
        $this->call('CatalogoNominaSeeder');
    }
}
