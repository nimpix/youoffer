<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="width:100%;">
            <a class="navbar-brand" href="#">Youoffer</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="templates-aside" @click="switchSlide('template')">Шаблоны</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="catalog-aside" @click="switchSlide('catalog')">Каталог</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Exel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">PDF</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/backend/web">Админка</a>
                    </li>
                    <li class="nav-item">
                        <a href="/logout" class="nav-link">Выйти</a>
                    </li>
                </ul>
            </div>
        </nav>

        <transition name="slide">
            <aside id="template-side" v-if="slidetemplate">
                <label for="">Поиск шаблонов</label>
                <form action="" class="form-inline filter-templates">
                    <div class="form-group">
                        <input type="text" class="form-control">
                        <input type="submit" value="Поиск" class="btn btn-primary ml-2">
                    </div>
                </form>
                <ul class="list-group templates-list" v-for="template in templates">
                    <li class="list-group-item list-group-item-action bg-warning font-weight-bold">{{ template.name }}</li>
                </ul>
            </aside>
        </transition>
        <aside id="catalog-side" v-if="slidevis">
            <label for="">Каталог</label>
        </aside>
    </div>
</template>

<script>
    export default {
        name: "Menu",
        data:function () {
           return {
               slidevis: false,
               slidetemplate:false
           }
        },
        computed: {
            templates() {
                //вызываем нужный экшон который вызывает свою мутацию
                return this.$store.getters.get_all_templates  //получаем результат
            },
        },
        methods: {
            switchSlide:function (e) {
                switch (e) {
                    case "template":
                        this.slidetemplate = !this.slidetemplate;
                        this.slidevis =  false;
                        break;
                    case "catalog":
                        this.slidevis =  !this.slidevis;
                        this.slidetemplate = false;
                        break;
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .templates-list{
        margin-top: 30px;
        & li{
            color: #902f2f !important;
        }
    }
    .slide-transition{
        transition:all 2s linear;
    }

    .slide-enter{
        width:0px;
    }

    .slide-leave-to {
       width:0px;
    }

    .navbar .in {
        display: block !important;
    }
    .filter-templates{
        display:block !important;
    & .form-control{
          width:180px !important;
      }
    }

    #template-side{
        color: #aaabae;
        width: 300px;
        float: left;
        height: 100vh;
        background: #303641;
        -webkit-box-shadow: 3px 0px 3px 0px rgba(105, 105, 105, 0.58);
        -moz-box-shadow: 3px 0px 3px 0px rgba(105, 105, 105, 0.58);
        box-shadow: 3px 0px 3px 0px rgba(105, 105, 105, 0.58);
        transition:0.3s;
        margin-right: 40px;
        padding:40px 15px;
        position: relative;
    }
    #catalog-side{
        color: #aaabae;
        width: 300px;
        float: left;
        height: 100vh;
        background: #303641;
        -webkit-box-shadow: 3px 0px 3px 0px rgba(105, 105, 105, 0.58);
        -moz-box-shadow: 3px 0px 3px 0px rgba(105, 105, 105, 0.58);
        box-shadow: 3px 0px 3px 0px rgba(105, 105, 105, 0.58);
        transition:0.3s;
        margin-right: 40px;
        padding:40px 15px;
        position: relative;
    }
</style>