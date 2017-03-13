<template>
  <div id="app">
    <div class="eventHandler"></div>
    <router-view @buttonState="setButtonState($event)"></router-view>
    <fish-menu :state="buttonState" ></fish-menu>
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
  created () {
    this.$on('buttonState', function (data) {
      console.log('(App) Got an emit: buttonState')
    })
  },
  methods: {
    setButtonState (event) {
      console.log('(App) Got an emit: buttonState')
      this.buttonState = event
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
