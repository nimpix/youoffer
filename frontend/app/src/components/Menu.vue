<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="width:100%;">
            <a class="navbar-brand" href="#">Youoffer</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav col-8">
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
                <div class="col-4 justify-content-end right-block"><div class="text-right">
                    <router-link :to="{ name: 'template', params: { templateId: templateId }}">
                        <div style="color:#ff3119;" class="card-error" v-if="choose">Выберите шаблон</div>
                        <div class="card-title" @click="chooseTemplate">Корзина</div>
                    </router-link></div></div>
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
                <ul class="list-group templates-list" v-for="(template,index) in templates" :key="index">
                    <li  @click="selectTemplate(template.id)" class="list-group-item list-group-item-action font-weight-bold" >{{ template.name }}</li>
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
               slidetemplate:false,
               choose:false
           }
        },
        computed: {
            templates() {
                //вызываем нужный экшон который вызывает свою мутацию
                return this.$store.getters.get_all_data.templates  //получаем результат
            },
            templateId(){
                return this.$store.state.templateId
            },
            currentTemplate(){
               // return this.$store.getters.get_current_template
            }
        },
        methods: {
            // randomColor:function(){
            //     let r=Math.floor(Math.random() * (256));
            //     let g=Math.floor(Math.random() * (256));
            //     let b=Math.floor(Math.random() * (256));
            //     return 'rgb(' + r +','+ g +','+ b+')';
            // },
            chooseTemplate:function(){
              this.choose = (this.templateId == '')  ? true : false
            },
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
            },
            selectTemplate:function (id) {
                this.choose = false
                this.$store.dispatch('set_template_id_current',id);
            }
        },
    }
</script>

<style scoped lang="scss">
    .card-title{
        display: inline;
        margin-left: 20px;
        cursor:pointer;
        color: rgba(255,255,255,.5);
        margin-top: 7px;
        &:hover{
            text-decoration: none !important;
        }
    }

    .card-error{
        display: inline;
    }

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