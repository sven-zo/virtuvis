<template>
  <div id="app">
    <router-view></router-view>
    <fish-menu></fish-menu>
  </div>
</template>

<script>
import FishMenu from '@/components/FishMenu.vue'
import Fingerprint2 from 'fingerprintjs2'

new Fingerprint2().get(function (result, components) {
  console.log(result) //  a hash, representing your device fingerprint
  console.log(components) // an array of FP components
})

export default {
  name: 'app',
  components: {
    FishMenu
  }
}

// This script runs after the loading is done, so here the loading message will be removed.
var shell = document.getElementById('shell')
var load = document.getElementById('load')

shell.removeChild(load)
</script>

<style lang="sass">
#app
  -webkit-font-smoothing: antialiased
  -moz-osx-font-smoothing: grayscale
</style>
