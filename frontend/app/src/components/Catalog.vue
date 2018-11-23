<template id="catalog-template">
    <div class="user-body">
       <div v-if="page>1" class="clearfix w-100 mb-4 text-right font-weight-bold title-pagination">Страница {{ page }}</div>
        <div class="clearfix btn-group justify-content-end w-100 mb-4">
            <button v-if="page>1" type="button" class="btn btn-sm btn-primary outline" @click="page = 1">В начало</button>
            <button type="button" class="btn btn-sm btn-primary outline" v-if="page != 1" @click="page--"> Предыдущая </button>
            <button type="button" :class="'btn btn-sm btn-primary outline'+ current " :data="(page == pageNumber) ? '1': '2'" v-for="(pageNumber,index) in pages.slice(page-1, page+3)" :key="index" @click="changePage(pageNumber)"> {{pageNumber}} </button>
            <button type="button" @click="page++" v-if="page < pages.length-4" class="btn btn-sm btn-primary outline"> Следующая </button>
        </div>
        <div class="row">
            <Card v-for="(prod,index) in displayedProds" :key="index" :item="prod"></Card>
        </div>'
    </div>
</template>


<script>
    import Card from '@/components/Card.vue'

    export default {
        name: 'Catalog',
        components: {
            Card
        },
        data: function () {
            return {
                pages: [],
                page: 1,
                perPage:20,
                current: '',
            }
        },
        props: {},
        computed: {
            prods() {
                //вызываем нужный экшон который вызывает свою мутацию
              return this.$store.getters.get_products  //получаем результат
            },
            displayedProds () {
               return this.paginate(this.prods);
            }
        },
        methods:{
            setPages () {
                let numberOfPages = Math.ceil(this.prods.length / this.perPage)
                for (let index = 1; index <= numberOfPages; index++) {
                   if(this.pages.length == numberOfPages){   //Просчитываем индексы
                       break;
                   }
                   this.pages.push(index);
                }
            },
            paginate (pprods) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return  pprods.slice(from, to);  //отрисовываем товары в пагинации
            },
            changePage(pageNumber){
                this.page = pageNumber
            }
        },
        watch: {
            prods () {
                this.setPages();
            }
        },
        created:function(){
            this.$store.dispatch('set_products');
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
    .user-body {
        width: 100%;
        height: calc(100vh - 60px);
        padding: 40px;
        & .col-lg-3 {
            margin-bottom: 15px !important;
            @media (min-width: 1400px) {
                max-width: 20%;
            }
        }

    }
    .outline{
       margin:0 10px;
    }
    .title-pagination{
        font-size:25px;
    }
</style>
