import moment from 'moment'
moment.locale('es')
export const Quincena = {
  calculaId: function (fecha) {
    let f = moment(fecha)
    let a = f.year()
    let m = f.month() + 1
    let d = f.date()
    let q = m * 2
    if (d < 16) {
      q -= 1
    }
    return a + this.llenarCeros(q)
  },
  calculaQuincena: function (id) {
    id = String(id)
    let a = parseInt(id.substring(0, 4))
    let q = parseInt(id.substring(4, 6))
    let di = 1
    let df = 15
    let m = 0
    let _q = q % 2
    if (_q === 0) {
      m = q / 2
      di = 16
      df = 30
      if (m === 2) {
        df = 28
      }
    } else {
      m = (q + 1) / 2
    }
    let f = moment([a, m - 1, di])
    let fechaInicio = moment([a, m - 1, di])
    let fechaFin = moment([a, m - 1, df])
    let mes = f.format('MMMM').toUpperCase()
    let descripcion = (_q === 0) ? 'SEGUNDA' : 'PRIMERA'
    descripcion += ' QUINCENA DE ' + mes
    descripcion += ' DE ' + a
    return {
      id: id,
      _quincena: _q,
      quincena: q,
      inicio: fechaInicio,
      fin: fechaFin,
      descripcion: descripcion,
      mes: mes,
      _mes: m,
      anio: a
    }
  },
  quincenaActual: function () {
    let id = parseInt(this.calculaId(new Date()))

    return this.calculaQuincena(id)
  },
  llenarCeros: function (n) {
    let ceros = '00'
    return (ceros + n).slice(-ceros.length)
  }
}
