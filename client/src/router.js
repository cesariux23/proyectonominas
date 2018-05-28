import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store'

import Login from './components/site/Login'
// EMPLEADOS
import Empleados from './components/Empleados'
import ListaEmpleados from './components/empleados/ListaEmpleados'
import DetalleEmpleado from './components/empleados/DetalleEmpleado'
import EditarEmpleado from './components/empleados/EditarEmpleado'
import RegistrarEmpleado from './components/empleados/RegistrarEmpleado'
import Movimientos from './components/empleados/Movimientos'
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
import CatalogoAdscripciones from './components/catalogos/CatalogoAdscripciones'
import ListaCatalogoNominas from './components/catalogos/nominas/ListaCatalogoNominas'
import CatalogoConceptos from './components/catalogos/CatalogoConceptos'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    // site
    { path: '/login', name: 'login', component: Login },

    // ================== EMPLEADOS =====================
    // Generales
    { path: '/empleados',
      component: Empleados,
      children: [
        // this is also a route record
        { path: '/', component: ListaEmpleados, name: 'indexEmpleados' },
        { path: 'registro', component: RegistrarEmpleado, name: 'registroEmpleado' }
      ]
    },
    // Individuales
    { path: '/empleado',
      component: Empleados,
      children: [
        {
          path: ':id',
          component: DetalleEmpleado,
          name: 'detalleEmpleado'
        },
        {
          path: ':id/editar/:partial',
          name: 'empleadoEdit',
          component: EditarEmpleado
        },
        {
          path: ':id/movimientos/:accion',
          name: 'movimientos',
          component: Movimientos
        }
      ]
    },
    // ================== NOMINAS =====================
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
        {path: 'adscripciones', component: CatalogoAdscripciones},
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

router.beforeEach((to, from, next) => {
  // si no ha iniciado sesion, y no esta en el login, se redirecciona
  if (to.name !== 'login' && !store.getters.isAuthenticated) {
    store.commit('nextRoute', store.getters.rootPath)
    if (to.fullPath !== '/' && to.name !== 'login') {
      store.commit('nextRoute', to.fullPath)
    }
    next('/login')
  } else {
    // si ya inicio la sesion, se redirecciona a la raiz
    if (to.name === 'login' && store.getters.isAuthenticated) {
      next(store.getters.rootPath)
    } else {
      // se redireccionla a la ruta solicitada antes del login
      if (from.name === 'login' && store.getters.nextRoute) {
        let nextPath = store.getters.nextRoute
        store.commit('nextRoute', false)
        next(nextPath)
      } else {
        next()
      }
    }
  }
})

export default router
