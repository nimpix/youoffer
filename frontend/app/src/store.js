import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        products: [],
        one_product: [],
        all_data: [],
        template: [],
        order:[]
    },
    mutations: {
        products(state, data) {
            state.products = data
        },

        one_product(state, data) {
            state.one_product = data
        },

        all_data(state, data) {
            state.all_data = data
        },

        current(state, data) {
            state.template = data.template
        },

        order(state,data){
            state.order.push(data)
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
        },
        set_all_data: ({commit}) => {
            fetch('http://offer/backend/web/api-all', {
                headers: {
                    'Access-Control-Allow-Origin': "*"
                },
            })
                .then(function (response) {
                    return response.json()
                })
                .then(function (data) {
                    commit('all_data', data);
                });
        },
        set_template_current: ({commit}, template) => {
            commit({
                type: 'current',
                template: template
            })
        },

        set_order: ({commit}, order) => {
            commit('order', order)
        },
    },
    getters: {
        get_products: state => {
            return state.products
        },
        get_product: state => {
            let item;
            for (let prod of state.products) {
                if (prod.id == state.one_product) {
                    item = prod
                }
            }

            return item
        },
        get_all_data: state => {
            return state.all_data
        },
    }
})
