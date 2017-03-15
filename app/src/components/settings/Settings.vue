<template>
    <div class="settingsWrapper">
      <transition appear name="page">
      <div class="settings" v-if="userLanguage === 'nl'">
          <div class="upperBar">
            <p>
              Instellingen:
            </p>
          </div>
          <p>
            Hier komen de instellingen.
          </p>
          <p>
            Omdat we een dummy-server gebruiken, moet je nu de taal manually aanpassen.
          </p>
          <p>
            Maar, bijna alle pagina's hebben een Nederlandse en Engelse vertaling.
          </p>
      </div>
      <div class="settings" v-if="userLanguage === 'en'">
          <div class="upperBar">
            <p>
              Settings:
            </p>
          </div>
          <p>
            Here's where the settings are.
          </p>
          <p>
            Omdat we een dummy-server gebruiken, moet je nu de taal manually aanpassen.
          </p>
          <p>
            Maar, bijna alle pagina's hebben een Nederlandse en Engelse vertaling.
          </p>
      </div>
    </transition>
    </div>
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
</style>
