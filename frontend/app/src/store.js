import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    products: []
  },
  mutations: {
    products(state, data){
        state.products = data
    }
  },
  actions: {
    set_products: ({commit}) => {
        fetch('http://offer/backend/web/api-getprods', {
            // mode: 'no-cors',
            headers: {
                'Access-Control-Allow-Origin': "*"
            },
        })
            .then(function (response) {
                return response.json()
            })
            .then(function (data) {
                commit('products', data);
            });
    }
  },
  getters:{
    get_products: state => {
      return state.products
    }
  }
})
