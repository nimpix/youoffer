Vue.component('catalog', {
    data: function () {
        return {

        }
    },
    props:['products'],
    template: '<div class="row"><card v-for="prod in products" :pid="prod.id" :item="prod"></card></div>'
})

Vue.component('card', {
    data: function () {
        return {

        }
    },
    props:['item'],
    template: '<div class="card-body col-3"><div class="card-image"><img class="img-responsive" :src="item.image" alt=""></div></div>'
})

new Vue({
    el:'#app',
    delimiters: ['{','}'],
    data:{
            prods:[],
            catalog: false,
            mytemps: false,
    },
    created:function () {
        var vm = this
        // Fetch our array of posts from an API
        fetch('/jsonprods')
            .then(function (response) {
                return response.json()
            })
            .then(function (data) {
                vm.prods = data
            })
    }
})
