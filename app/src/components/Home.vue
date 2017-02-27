<template>
    <div class="home">
        <p>Home</p>
        <router-link to="/fish">Vis</router-link>
        <router-link to="/settings">Instellingen</router-link>
    </div>
</template>

<script>
    export default {
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="sass" scoped>
    @import 'src/style/_palette.sass'
    h1
        color: $primary-color
        font-family: 'Roboto', sans-serif
    p
        color: black
        font-family: 'Roboto', sans-serif
</style>
