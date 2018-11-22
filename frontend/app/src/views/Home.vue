<template>
  <div class="home">
    <Menu></Menu>
    <Catalog></Catalog>
  </div>
</template>

<script>
// @ is an alias to /src
import Catalog from '@/components/Catalog.vue'
import Menu from '@/components/Menu.vue'

export default {
  name: 'home',
  components: {
      Menu,
      Catalog
  }
}
</script>
