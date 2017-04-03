<!-- Dit is het component voor de pagina waar je je vishengel kan toevoegen. -->
<!-- Deze pagina is subject to change, als we VirtuVision gaan gebruiken, misschien telefoon onder camera houden, en dobber er dan op leggen?-->
<template lang="pug">
.wrapper
  transition(appear, name='loading')
    .loading(v-if='loading')
      p#loadingMSG Loading...
      #loader Loading...
  //-
    'transition' zorgt ervoor dat de het compontent kan worden geanimeerd.
    'appear' wordt gebruikt om deze animatie uit te voeren bij het ontstaan van het element.
    'name' duidt op de naam van de animatie, die onder is beschreven in de SASS
  transition(appear, name='page')
    .settings(v-if='userLanguage == "nl"')
      .upperBar
        p  Vishengel kiezen:
      .bottomBar
        p  Kies je vishengel:
      .debug
        p {{rods}}
    .settings(v-if='userLanguage == "en"')
      .upperBar
        p  Choose a fishing rod:
      .bottomBar
        p Choose your fishing rod:
</template>

<script>
// import {getUserSettings} from '../../script/userSettings.js'
import {getData} from '../../script/getData.js'

export default {
  data: function () {
    return {
      userLanguage: null,
      loaded: false,
      loading: false,
      error: null,
      errorMessage: 'Failed to get error message',
      caughtText: '...',
      rods: null
    }
  },
  /*
  / Deze hook wordt opgeroepen wanneer dit component wordt geschapen.
  / Als het component wordt geschapen, wordt de taal van de gebruiker opgezocht.
  */
  created () {
    this.getFishingRodPage()
    this.$emit('buttonColor', '#673AB7')
  },
  methods: {
    /*
    / Deze methode haalt de taal van de gebruiker op.
    / Dit wordt gedaan via een apart script met een functie met dezelfde naam.
    */
    getFishingRodPage () {
      var self = this
      getData('user').then(function (response) {
        console.log('[AddRod] Succes! (Settings)', response.language)
        self.userLanguage = response.language
        console.log('[AddRod] Language data attached')
        console.log('[AddRod] Language: ', self.userLanguage)
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserSettings@getUserSettings@AddRod] (' + error + ')'
        console.log('[AddRod] Failed! (Settings)', error)
        self.error = true
      })
      getData('rod').then(function (response) {
        console.log('[AddRod] Retrieved list of rods', response.rods)
        self.rods = response.rods
        self.loading = false
        self.loaded = true
        console.log('[AddRod] Rod data attached')
      }, function (error) {
        self.errorMessage = '[promise_failed_getData@getFishingRod@AddRod] (Error: ' + error + ')'
        console.log('[AddRod] Failed! (Rodlist)', error)
        self.loading = false
        self.error = true
      })
    }
  }
}
</script>

<style lang="sass" scoped>
//*
// Dit importeert de palette file en het loading animatietje.
// De underscore duidt aan dat het bestand niet geëxporteert hoeft te worden.
@import '../../style/palette.sass'
@import '../../style/loading.css'

.bottomBar
  background-color: white
  width: 100%

.bottomBar p
  color: $primary-text-color
  font-size: 24px
  font-family: 'Roboto', sans-serif
  text-align: center
  padding-top: 10px
  margin-top: 0px

.upperBar
  background-color: $primary-color-dark
  height: 30px
  width: 100%

.upperBar p
  color: white
  margin-left: 15px
  margin-top: 0px
  padding-top: 4px
  font-family: 'Roboto', sans-serif
  font-size: 18px

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif

.debug p
  color: black
  font-family: 'Roboto', sans-serif

.page-enter-active
  transition: opacity .2s

.page-enter
  opacity: 0

.loading-enter-active
  transition: opacity 1s

.loading-enter
  opacity: 0
</style>
