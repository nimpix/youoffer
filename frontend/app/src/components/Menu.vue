<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="width:100%;max-height:60px;">
            <a class="navbar-brand" href="#">Youoffer</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav col-6">
                    <li class="nav-item active">
                        <router-link :to="{ name: 'home' }">
                        <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                        </router-link>
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
                <div class="col-4 text-center font-weight-bold template__title-current">
                  <div style="" v-if="currentTemplate.name !== undefined">Шаблон {{ currentTemplate.name }}</div>
                </div>
                <div class="col-2 justify-content-end right-block"><div class="text-right">
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
                <ul class="list-group templates-list" v-for="(template_item,index) in templates" :key="index">
                    <li  @click="selectTemplate(template_item.id)" class="list-group-item list-group-item-action font-weight-bold" >{{ template_item.name }}</li>
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
               choose:false,
               currentTemplate: this.$store.state.template
           }
        },
        computed: {
            templateId(){
                return this.$store.state.template.id
            },
            templates(){
                return this.$store.getters.get_all_data.templates
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

              this.choose = (this.templateId == undefined)  ? true : false
                console.log(this.templateId)
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
            //Выбираем шаблон из списка
            selectTemplate:function (id) {
                let result;
                this.choose = false
                    for(let item of this.templates){
                      if(item.id == id){
                          result = item
                      }
                    }

                this.currentTemplate = result
                //Сохраняем шаблон в хранилище в текущий шаблон
                this.$store.dispatch('set_template_current',this.currentTemplate);
            }
        },
        created: function(){
                //получаем все api set_all_data
               this.$store.dispatch('set_all_data');
               //выбираем шаблоны
        }
    }
</script>

<style scoped lang="scss">
    .template__title-current{
        font-size:30px;
        color:#FFF;
    }
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
        position: absolute;
        background: #a51010;
        width: 149px;
        font-size: 15px;
        right: 200px;
        top: -10px;
        color: #FFF !important;
        padding: 10px 9px;
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