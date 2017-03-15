<template lang="pug">
.wrapper
  transition(appear, name='loading')
    .loading(v-if='loading')
      p#loadingMSG Loading settings...
      #loader Loading...
  transition(appear, name='page')
    .loaded(v-if='loaded')
      .settings(v-if="userLanguage === 'nl'")
        .upperBar
          p  Instellingen:
        p  Hier komen de instellingen.
        p  Omdat we een dummy-server gebruiken, moet je nu de taal manually aanpassen.
        p  Maar, bijna alle pagina's hebben een Nederlandse en Engelse vertaling.
      .settings(v-if="userLanguage === 'en'")
        .upperBar
          p  Settings:
        p  Here's where the settings are.
        p  Omdat we een dummy-server gebruiken, moet je nu de taal manually aanpassen.
        p  Maar, bijna alle pagina's hebben een Nederlandse en Engelse vertaling.
</template>

<script>
import {getUserSettings} from '../../script/userSettings.js'

export default {
  data: function () {
    return {
      userLanguage: null,
      loaded: false,
      loading: false,
      error: null,
      errorMessage: 'Failed to get error message',
      caughtText: '...'
    }
  },
  /*
  / Deze hook wordt opgeroepen wanneer dit component wordt geschapen.
  / Als het component wordt geschapen, wordt de taal van de gebruiker opgezocht.
  */
  created () {
    this.getUserSettings()
  },
  methods: {
    /*
    / Deze methode haalt de taal van de gebruiker op.
    / Dit wordt gedaan via een apart script met een functie met dezelfde naam.
    */
    getUserSettings () {
      var self = this
      this.loading = true
      getUserSettings().then(function (response) {
        console.log('[Settings] Succes! (Settings)', response.language)
        self.loading = false
        self.loaded = true
        self.userLanguage = response.language
        console.log('[Settings] Language data attached')
        console.log('[Settings] Language: ', self.userLanguage)
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserSettings@getUserSettings@AddRod] (' + error + ')'
        console.log('Failed! (Settings)', error)
        self.loading = false
        self.error = true
      })
    }
  }
}
</script>

<style lang="sass" scoped>
@import '../../style/palette.sass'
@import url('https://fonts.googleapis.com/css?family=Roboto')

.upperBar
  background-color: $primary-color-dark
  //height: 5vw
  height: 30px
  width: 100%

.upperBar p
  color: white
  margin-left: 15px
  margin-top: 0px
  padding-top: 4px
  font-family: 'Roboto', sans-serif
  //font-size: 3vw
  font-size: 18px

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif
p
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
