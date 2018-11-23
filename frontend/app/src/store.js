import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        products: [],
        one_product: ''
    },
    mutations: {
        products(state, data) {
            state.products = data
        },
        one_product(state,data){
            state.one_product = data
        }
    },
    actions: {
        set_products: ({commit}) => {
            fetch('http://offer/backend/web/api-getprods', {
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
        },
        set_one_product: ({commit}, id_prod) => {
            commit('one_product', id_prod)
        }
    },
    getters: {
        get_products: state => {
            return state.products
        },
        get_product: state => {
            let item;
            for(let prod of state.products){
                if(prod.id ==state.one_product){
                    item = prod
                }
            }

            return item
        }
    }
})
