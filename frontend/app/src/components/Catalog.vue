<template id="catalog-template">
    <div class="user-body">

    </div>
</template>


<script>
    export default {
        name: 'Catalog',
        data: function () {
            return {
                prods: [],
            }
        },
        props: {},
        created: function () {
            let vm = this
            // Fetch our array of posts from an API
            fetch('http://offer.com/jsonprods')
                .then(function (response) {
                    return response
                }).then(function (data) {
                    vm.prods = data
                    console.log(data)
                })
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">

    .content {
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

    #content {

    }

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
</style>
