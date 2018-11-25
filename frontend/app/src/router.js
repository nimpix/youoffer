import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Details from './views/Details.vue'
import Template from './views/Template.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
       path: '/details/:idprod',
       name: 'details',
       component: Details
    },
    {
        path:'/template/:templateId',
        name:'template',
        component:Template
    }
  ]
})
