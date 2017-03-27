<template>
  <div id="app">
    <div class="eventHandler"></div>
    <router-view @buttonColor='buttonColorManager($event)' @userLanguage='languageManager($event)' @buttonState='buttonStateManager($event)'></router-view>
    <fish-menu :color='buttonColor' :lang="userLanguage" :state="buttonState" @buttonReset="buttonReset()"></fish-menu>
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
  },
  data: function () {
    return {
      buttonColor: '#673AB7',
      buttonState: null,
      userLanguage: null
    }
  },
  methods: {
    buttonStateManager (data) {
      console.log('[App] Got data from [Home]: buttonState')
      console.log('[App] Setting buttonState prop in: [FishMenu]')
      this.buttonState = data
    },
    buttonReset () {
      console.log('[App] Resetting button state')
      this.buttonState = 'null'
    },
    languageManager (data) {
      console.log('[App] Got data from [Home]: userLanguage')
      console.log('[App] Setting lang prop in: [FishMenu]')
      this.userLanguage = data
    },
    buttonColorManager (data) {
      console.log('[App] Got data from [anonymous]: buttonColor')
      console.log('[App] Setting color prop in: [FishMenu]')
      this.buttonColor = data
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
