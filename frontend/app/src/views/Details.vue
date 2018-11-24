<template>
    <div>
        <Menu></Menu>
        <div class="card__body container">
           <div class="row">
               <div class="col-6">
                   <img :src="data.image" alt="">
               </div>
               <div class="col-6">
                   <div class="title font-weight-bold"> {{ data.name }}</div>
                   <div class="articul"><span>Артикул:</span> {{ data.articul }}</div>
                   <div class="price-roz"><span>Розничная цена:</span> {{ data.price_roznica }} р.</div>
                   <div class="price-opt"><span>Оптовая цена:</span> {{ data.price_opt}} р.</div>
                   <div class="status"><span>Статус(наличие):</span> {{ data.status }}</div>
                   <div class="category"><span>Категория:</span><ul class="sections" v-for="sections in data.sections"><li>{{ sections.name }}</li></ul></div>
                   <div class="brand"><span>Бренд:</span> {{ data.brands.name }}</div>
                   <div class="merch"><span>Поставщик:</span> {{ data.merchants.name }}</div>
                   <div class=""><div class="btn btn-primary btn-add">Добавить</div></div>
               </div>
           </div>
            <div class="row">
                <div class="col-12">
                    <div class="description">
                        <div class="clearfix font-weight-bold">Описание</div>
                        {{ description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Menu from '@/components/Menu.vue'

    export default {
        name: "Details",
        components:{
            Menu
        },
        created:function(){
             this.$store.dispatch('set_one_product',this.$route.params.idprod);
        },
        computed:{
            data(){
                return this.$store.getters.get_product
            },
            description(){
                return (this.data.description !== ' ') ? this.data.description : 'Описание отсутствует'
            }
        }
    }
</script>

<style scoped lang="scss">
    img{
        display: block;
        width:400px;
        height:400px;
    }
    .card__body{
        padding:100px 50px 40px 50px;
        & .articul,.price-roz,.price-opt,.status,.category,.brand{
         margin-bottom: 20px;
        }
        & .title{
            margin-bottom: 40px;
            font-size: 30px;
        }
    }
    .description{
        margin-top: 100px;
    }
    .btn-add{
        margin-top: 20px;
    }
    .sections{
        margin-top: 15px;
    }
</style>