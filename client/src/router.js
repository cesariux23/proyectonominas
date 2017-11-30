import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from './components/site/Login'
// EMPLEADOS
import Empleados from './components/Empleados'
import ListaEmpleados from './components/empleados/ListaEmpleados'
import DetalleEmpleado from './components/empleados/DetalleEmpleado'
import EditarEmpleado from './components/empleados/EditarEmpleado'
import RegistrarEmpleado from './components/empleados/RegistrarEmpleado'
// NOMINAS
import Nominas from './components/Nominas'
import ListaNominas from './components/nominas/ListaNominas'
import DetalleNomina from './components/nominas/DetalleNomina'
import EditarNomina from './components/nominas/editar/EditarNomina'
import ListaEmpleadosNomina from './components/nominas/editar/ListaEmpleadosNomina'
import DesgloseEmpleado from './components/nominas/editar/DesgloseEmpleado'
import CrearNuevaNomina from './components/nominas/CrearNuevaNomina'

// CATALOGOS
import Catalogos from './components/Catalogos'
import CatalogoNominas from './components/catalogos/CatalogoNominas'
import ListaCatalogoNominas from './components/catalogos/nominas/ListaCatalogoNominas'
import CatalogoConceptos from './components/catalogos/CatalogoConceptos'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    // the following object is a route record
    { path: '/login', component: Login },
    { path: '/empleados',
      component: Empleados,
      children: [
        // this is also a route record
        { path: '', component: ListaEmpleados },
        { path: 'new', component: RegistrarEmpleado },
        {
          path: ':id',
          component: DetalleEmpleado,
          name: 'detalleEmpleado'
        },
        {
          path: ':id/editar/:partial',
          name: 'empleadoEdit',
          component: EditarEmpleado
        }
      ]
    },
    { path: '/nominas',
      component: Nominas,
      children: [
        { path: '', component: ListaNominas },
        { path: 'new', component: CrearNuevaNomina },
        { path: ':id', component: DetalleNomina },

        {
          path: ':id/edit',
          component: EditarNomina,
          children: [
            {path: '', component: ListaEmpleadosNomina},
            {path: 'desglose/:empleado', component: DesgloseEmpleado}
          ]
        }
      ]
    },
    { path: '/catalogos',
      component: Catalogos,
      children: [
        {path: 'nominas',
          component: CatalogoNominas,
          children: [
            {path: '', component: ListaCatalogoNominas}
          ]
        },
        {path: 'conceptos', component: CatalogoConceptos}
      ]
    }
  ]
})

export default router
