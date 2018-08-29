import * as actions from './actions'
import defaultState from './defaultState'
import * as mutations from './mutations'
import * as getters from './getters'

const inBrowser = typeof window !== 'undefined'
// if in browser, use pre-fetched state injected by SSR
const state = (inBrowser && window.__INITIAL_STATE__) ? window.__INITIAL_STATE__.desgloses : defaultState

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
