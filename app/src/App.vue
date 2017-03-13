<template>
  <div id="app">
    <div class="eventHandler"></div>
    <router-view @buttonState='buttonStateManager($event)'></router-view>
    <fish-menu :state="buttonState" @buttonReset="buttonReset()"></fish-menu>
  </div>
</template>

<script>
import FishMenu from '@/components/FishMenu.vue'

export default {
  name: 'app',
  components: {
    FishMenu
  },
  data: function () {
    return {
      buttonState: null
    }
  },
  methods: {
    buttonStateManager (data) {
      console.log('(App) Got data from Home: buttonState')
      console.log('(App) Setting prop in: FishMenu')
      this.buttonState = data
    },
    buttonReset () {
      console.log('(App) Resetting button state')
      this.buttonState = 'null'
    }
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
