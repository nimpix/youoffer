<template>
  <div id="app">
    <Home />
  </div>
</template>

<script>
    import Home from '@/views/Home.vue'
    import Catalog from '@/components/Catalog.vue'

    export default {
        name: 'app',
        components: {
            Home
        }
    }
</script>

<style lang="scss">

</style>
