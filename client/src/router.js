import Vue from 'vue'
import VueRouter from 'vue-router'
import Empleados from './components/Empleados'
import ListaEmpleados from './components/empleados/ListaEmpleados'
import Catalogos from './components/Catalogos'
import DetalleEmpleado from './components/empleados/DetalleEmpleado'
import EditarEmpleado from './components/empleados/EditarEmpleado'
import RegistrarEmpleado from './components/empleados/RegistrarEmpleado'
// Nominas
import Nominas from './components/Nominas'
import ListaNominas from './components/nominas/ListaNominas'
import DetalleNomina from './components/nominas/DetalleNomina'
import EditarNomina from './components/nominas/editar/EditarNomina'
import ListaEmpleadosNomina from './components/nominas/editar/ListaEmpleadosNomina'
import DesgloseEmpleado from './components/nominas/editar/DesgloseEmpleado'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    // the following object is a route record
    { path: '/empleados',
      component: Empleados,
      children: [
        // this is also a route record
        { path: '', component: ListaEmpleados },
        { path: 'new', component: RegistrarEmpleado },
        { path: ':id', component: DetalleEmpleado },
        { path: ':id/edit', component: EditarEmpleado }
      ]
    },
    { path: '/nominas',
      component: Nominas,
      children: [
        { path: '', component: ListaNominas },
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
    { path: '/catalogos', component: Catalogos
      // children: [
      //   // this is also a route record
      //   { path: 'bar', component: Bar }
      // ]
    }
  ]
})

export default router
