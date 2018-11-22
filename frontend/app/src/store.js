import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    products: []
  },
  mutations: {
    set(state,{ type ,items }){
        state[type] = items
    }
  },
  actions: {
    set_products: ({commit},args) => {
        const url = 'http://offer.com/jsonprods'

        fetch(url)
             .then(function (response) {
                    return response.json()
             }).then(function (data){
                 const  result = data;
                 commit('set',{ type: 'products', items: result})
            })
    }
  },
  getters:{
    products: state => {
      return state.products
    }
  }
})
