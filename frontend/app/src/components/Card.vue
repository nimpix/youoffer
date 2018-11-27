<template>
    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 card-wrap" @click="routeToDetail(item)">
        <div class="card-body">
            <div class="card-image"><img class="img-responsive" :src="item.thumbnails" alt=""></div>
            <div class="title">{{ item.name }}</div>
            <div class="price">{{ item.price_roznica }} р.</div>
            <Button :id="item.id"></Button>
        </div>
    </div>
</template>

<script>
    import Button from '@/components/ButtonOrder.vue'
    export default {
        name: "Card",
        props:['item'],
        data:function () {
            return{

            }
        },
        methods:{
            routeToDetail:function (item) {
                this.$router.push({  name: 'details', params: { idprod: item.id}})
            }
        },
        components:{
            Button
        }
    }
</script>

<style scoped lang="scss">

    .card-body {
        border: 1px solid #dedede;
        height: 100%;
        margin: 5px;
        text-align: center;
    }

    .card-image {
        min-height: 270px;
        display: flex;
        flex-flow: row wrap;
        align-items: center;
        justify-content: center;
    }

    .img-responsive {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .price {
        text-align: center;
        width: 100%;
        margin-top: 20px;
        font-weight: bold;
    }
    .title{
        min-height:45px;
    }
    .card-wrap{
        cursor:pointer;
    }
</style>