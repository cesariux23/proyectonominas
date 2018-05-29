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
      $plazas = json_decode('
      [
        {
          "clave": "B203172",
          "nombre": "OFICIAL DE SERVICIOS Y MANTENIMIENTO",
          "zona": 2,
          "nivel": 2
        },
        {
          "clave": "B218192",
          "nombre": "ADMINISTRATIVO ESPECIALIZADO",
          "zona": 2,
          "nivel": 2
        },
        {
          "clave": "B243232",
          "nombre": "SECRETARIA C",
          "zona": 2,
          "nivel": 23
        },
        {
          "clave": "B246211",
          "nombre": "AUXILIAR DE ADMINISTRADOR",
          "zona": 2,
          "nivel": 21
        },
        {
          "clave": "B247222",
          "nombre": "TECNICO MEDIO",
          "zona": 2,
          "nivel": 22
        },
        {
          "clave": "B259242",
          "nombre": "ESPECIALISTA EN PROYECTOS TECNICOS",
          "zona": 2,
          "nivel": 24
        },
        {
          "clave": "B265262",
          "nombre": "COORDINADOR EN TECNICAS DE COMPUTACION",
          "zona": 2,
          "nivel": 26
        },
        {
          "clave": "B270252",
          "nombre": "ANALISTA ADMINISTRATIVO",
          "zona": 2,
          "nivel": 25
        },
        {
          "clave": "B281272",
          "nombre": "JEFE DE OFICINA",
          "zona": 2,
          "nivel": 25
        },
        {
          "clave": "B282Z02",
          "nombre": "TECNICO DOCENTE",
          "zona": 2,
          "nivel": "ZA"
        },
        {
          "clave": "B285ZA2",
          "nombre": "TECNICO SUPERIOR",
          "zona": 2,
          "nivel": 27
        },
        {
          "clave": "B343232",
          "nombre": "SECRETARIA C",
          "zona": 3,
          "nivel": 23
        },
        {
          "clave": "B347222",
          "nombre": "TECNICO MEDIO",
          "zona": 3,
          "nivel": 22
        },
        {
          "clave": "B359242",
          "nombre": "ESPECIALISTA EN PROYECTOS TECNICOS",
          "zona": 3,
          "nivel": 24
        },
        {
          "clave": "B365262",
          "nombre": "COORDINADOR EN TECNICAS DE COMPUTACION",
          "zona": 3,
          "nivel": 26
        },
        {
          "clave": "B370252",
          "nombre": "ANALISTA ADMINISTRATIVO",
          "zona": 3,
          "nivel": 25
        },
        {
          "clave": "B381272",
          "nombre": "JEFE DE OFICINA",
          "zona": 3,
          "nivel": 5
        },
        {
          "clave": "B382Z02",
          "nombre": "TECNICO DOCENTE",
          "zona": 3,
          "nivel": "ZA"
        },
        {
          "clave": "B385ZA2",
          "nombre": "TECNICO SUPERIOR",
          "zona": 3,
          "nivel": "ZA"
        },
        {
          "clave": "C261Z02",
          "nombre": "SECRETARIA EJECUTIVA B",
          "zona": 2,
          "nivel": 27,
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C270252",
          "nombre": "ANALISTA ADMINISTRATIVO",
          "zona": 2,
          "nivel": 25,
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C282Z02",
          "nombre": "TECNICO DOCENTE",
          "zona": 2,
          "nivel": 27,
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C288ZB2",
          "nombre": "COODINADOR UNICO  DE SERV. ESPECIALIZ.",
          "zona": 2,
          "nivel": "7Z",
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C2921A3",
          "nombre": "COORDINADOR DE ZONA",
          "zona": 2,
          "nivel": "1A",
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C2931B3",
          "nombre": "JEFE DE DEPARTAMENTO",
          "zona": 2,
          "nivel": "1B",
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C2953A3",
          "nombre": "COORDINADOR REGIONAL",
          "zona": 2,
          "nivel": "3A",
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C2974A5",
          "nombre": "DIRECTOR GENERAL",
          "zona": 2,
          "nivel": "4A",
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C388ZB2",
          "nombre": "COORDINADOR UNICO EN SERV. ESPECIALIZ.",
          "zona": 3,
          "nivel": "7Z",
          "tipo": "CONFIANZA"
        },
        {
          "clave": "C3921A3",
          "nombre": "COORDINADOR DE ZONA",
          "zona": 3,
          "nivel": "1A",
          "tipo": "CONFIANZA"
        }
      ]
      ');

      foreach ($plazas as $plaza) {
        Plaza::firstOrCreate((array)$plaza);
      }
    }
}
