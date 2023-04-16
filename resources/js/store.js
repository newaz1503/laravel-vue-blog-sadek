import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
      count: 'saikot',
      permission: null
    },
    mutations: {
      increment (state) {
        state.count++
      },
      setPermission(state, data){
        state.permission = data
      }
    },
    actions:{

    },
    getters:{
        getPermission(state){
            return state.permission
        }
    }


  })
 export default store;
