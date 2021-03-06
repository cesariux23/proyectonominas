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

// procesos de nomina
import Procesos from './components/ProcesosNomina'
import ListaProcesos from './components/procesos/Listado'
import DetalleNomina from './components/procesos/DetalleNomina'
import DesgloseNomina from './components/procesos/Desglose'
import ConfigurarNomina from './components/procesos/editar/Configurar'
import AgregarEmpleados from './components/procesos/editar/AgregarEmpleados'
import ListaEmpleadosNomina from './components/procesos/editar/ListaEmpleados'
import DesgloseEmpleado from './components/procesos/editar/DesgloseEmpleado'
import NuevaNomina from './components/procesos/Nueva'

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
    // ================== PROCESOS DE NOMINAS =====================
    { path: '/nomina',
      component: Procesos,
      children: [
        { path: '', component: ListaProcesos, name: 'listNomina' },
        { path: 'nueva', component: NuevaNomina, name: 'nuevaNomina' },
        { path: ':id', component: DetalleNomina },

        {
          path: ':id/desglose',
          component: DesgloseNomina,
          children: [
            {
              path: '',
              component: ListaEmpleadosNomina,
              name: 'desgloseNomina'
            },
            {
              path: 'agregarEmpleados',
              component: AgregarEmpleados,
              name: 'agregarEmpleados'
            },
            {
              path: 'configurar',
              component: ConfigurarNomina,
              name: 'configurarNomina'
            },
            {
              path: 'empleado/:iddesglose',
              component: DesgloseEmpleado,
              name: 'editarDesgloseEmpleado'
            }
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
